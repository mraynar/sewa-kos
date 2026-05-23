<?php

namespace App\Http\Controllers\penyewa;

use App\Http\Controllers\Controller;
use App\Models\AdditionalService;
use App\Models\Booking;
use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class PenyewaController extends Controller
{
    public function index(Request $request)
    {
        $title      = "Griya Asri Kos | Hunian Eksklusif Mahasiswa";
        $categories = RoomType::all();
        $query      = Room::with('roomType');

        if ($request->filled('category')) {
            $query->where('room_type_id', $request->category);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('room_number', 'like', '%' . $request->search . '%')
                    ->orWhere('facilities', 'like', '%' . $request->search . '%');
            });
        }

        $rooms = $query->get();

        return view('penyewa.dashboard', compact('rooms', 'categories', 'title'));
    }

    public function show($id)
    {
        $room     = Room::with('roomType')->findOrFail($id);
        $services = AdditionalService::all();
        $title    = "Detail Kamar " . $room->room_number;

        return view('penyewa.transactions.show', compact('room', 'title', 'services'));
    }

    public function profile()
    {
        app(TransactionController::class)->checkPaymentStatus();

        $user  = auth()->user();
        $tab   = request('tab', 'edit');
        $title = "Profil Saya | Griya Asri Kos";

        $activeBookings = collect();
        if ($tab === 'report') {
            $activeBookings = Booking::with('room')
                ->where('user_id', $user->id)
                ->where('status', 'paid')
                ->get();
        }

        return view('penyewa.profile.index', compact('user', 'tab', 'title', 'activeBookings'));
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'nickname' => 'required|string|max:255|unique:users,nickname,' . $user->id,
            'phone'    => 'required|string|max:15|unique:users,phone,' . $user->id,
            'address'  => 'required|string',
        ], [
            'nickname.unique' => 'Nama panggilan sudah digunakan.',
            'phone.unique'    => 'Nomor HP sudah terdaftar.',
        ]);

        $user->update([
            'nickname' => $request->nickname,
            'phone'    => $request->phone,
            'address'  => $request->address,
        ]);

        return redirect()->route('profile', ['tab' => 'edit'])
            ->with('success', 'Profil berhasil diperbarui!');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password'      => 'required',
            'new_password'          => 'required|string|min:8|confirmed',
        ]);

        $user = auth()->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Kata sandi saat ini tidak sesuai.']);
        }

        $user->update(['password' => Hash::make($request->new_password)]);

        return redirect()->route('profile', ['tab' => 'password'])
            ->with('success', 'Kata sandi berhasil diperbarui!');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'full_name_ktp' => 'required|string|max:255',
            'birth_date'    => 'required|date|before:-15 years',
            'gender'        => 'required|in:Laki-laki,Perempuan',
            'address'       => 'required|string',
            'ktp_photo'     => 'required|image|max:2048',
            'selfie_photo'  => 'required|image|max:2048',
        ]);

        $user    = auth()->user();
        $ktpPath = $request->file('ktp_photo')->store('verifikasi/ktp', 'public');
        $selfiePath = $request->file('selfie_photo')->store('verifikasi/selfie', 'public');

        $user->update([
            'full_name_ktp' => $request->full_name_ktp,
            'birth_date'    => $request->birth_date,
            'gender'        => $request->gender,
            'address'       => $request->address,
            'ktp_photo'     => $ktpPath,
            'selfie_photo'  => $selfiePath,
            'is_verified'   => 'verified',
        ]);

        return redirect()->route('profile', ['tab' => 'verification'])
            ->with('success', 'Verifikasi identitas berhasil!');
    }

    public function report(Request $request)
    {
        $request->validate([
            'booking_id'  => 'required|exists:bookings,id',
            'issue_name'  => 'required|string|max:255',
            'description' => 'required|string',
            'issue_photo' => 'nullable|image|max:2048',
        ]);

        return redirect()->route('profile', ['tab' => 'report'])
            ->with('success', 'Laporan berhasil dikirim! Tim kami akan segera menindaklanjuti.');
    }
}
