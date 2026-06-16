<?php

namespace App\Http\Controllers\penyewa;

use App\Http\Controllers\Controller;
use App\Models\AdditionalService;
use App\Models\Booking;
use App\Models\MaintenanceRequest;
use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PenyewaController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Griya Asri Kos | Hunian Eksklusif Mahasiswa';
        $categories = RoomType::all();
        $query = Room::with('roomType');

        if ($request->filled('category')) {
            $query->where('room_type_id', $request->category);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('room_number', 'like', '%'.$request->search.'%')
                    ->orWhere('facilities', 'like', '%'.$request->search.'%');
            });
        }

        $rooms = $query->get();

        return view('penyewa.dashboard', compact('rooms', 'categories', 'title'));
    }

    public function show($id)
    {
        $room = Room::with('roomType')->findOrFail($id);
        $services = AdditionalService::all();
        $title = 'Detail Kamar '.$room->room_number;

        return view('penyewa.transactions.show', compact('room', 'title', 'services'));
    }

    public function profile()
    {
        app(TransactionController::class)->checkPaymentStatus();

        $user = auth()->user();
        $tab = request('tab', 'edit');
        $title = 'Profil Saya | Griya Asri Kos';

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
            'nickname' => 'required|string|max:255|unique:users,nickname,'.$user->id,
            'phone' => 'required|numeric|digits_between:10,15|unique:users,phone,'.$user->id,
            'address' => 'required|string',
        ], [
            'nickname.required' => 'Nama panggilan wajib diisi.',
            'nickname.max' => 'Nama panggilan maksimal 255 karakter.',
            'nickname.unique' => 'Nama panggilan sudah digunakan.',
            'phone.required' => 'Nomor WhatsApp wajib diisi.',
            'phone.numeric' => 'Nomor WhatsApp harus berupa angka.',
            'phone.digits_between' => 'Nomor WhatsApp harus antara 10 sampai 15 digit.',
            'phone.unique' => 'Nomor HP sudah terdaftar.',
            'address.required' => 'Alamat asal wajib diisi.',
        ]);

        $user->update([
            'nickname' => $request->nickname,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        return redirect()->route('profile', ['tab' => 'edit'])
            ->with('success', 'Profil berhasil diperbarui!');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ], [
            'current_password.required' => 'Kata sandi saat ini wajib diisi.',
            'new_password.required' => 'Kata sandi baru wajib diisi.',
            'new_password.min' => 'Kata sandi baru minimal 8 karakter.',
            'new_password.confirmed' => 'Konfirmasi kata sandi baru tidak cocok.',
        ]);

        $user = auth()->user();

        if (! Hash::check($request->current_password, $user->password)) {
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
            'birth_date' => 'required|date|before:-15 years',
            'gender' => 'required|in:Laki-laki,Perempuan',
            'address' => 'required|string',
            'ktp_photo' => 'required|image|max:2048',
            'selfie_photo' => 'required|image|max:2048',
        ], [
            'full_name_ktp.required' => 'Nama lengkap sesuai KTP wajib diisi.',
            'full_name_ktp.max' => 'Nama lengkap sesuai KTP maksimal 255 karakter.',
            'birth_date.required' => 'Tanggal lahir wajib diisi.',
            'birth_date.date' => 'Format tanggal lahir tidak valid.',
            'birth_date.before' => 'Usia minimal untuk mendaftar adalah 15 tahun.',
            'gender.required' => 'Jenis kelamin wajib dipilih.',
            'gender.in' => 'Jenis kelamin tidak valid.',
            'address.required' => 'Alamat lengkap wajib diisi.',
            'ktp_photo.required' => 'Foto KTP wajib diunggah.',
            'ktp_photo.image' => 'Berkas foto KTP harus berupa gambar.',
            'ktp_photo.max' => 'Ukuran foto KTP maksimal 2MB.',
            'selfie_photo.required' => 'Foto selfie dengan KTP wajib diunggah.',
            'selfie_photo.image' => 'Berkas foto selfie harus berupa gambar.',
            'selfie_photo.max' => 'Ukuran foto selfie maksimal 2MB.',
        ]);

        $user = auth()->user();
        $ktpPath = $request->file('ktp_photo')->store('verifikasi/ktp', 'public');
        $selfiePath = $request->file('selfie_photo')->store('verifikasi/selfie', 'public');

        $user->update([
            'full_name_ktp' => $request->full_name_ktp,
            'birth_date' => $request->birth_date,
            'gender' => $request->gender,
            'address' => $request->address,
            'ktp_photo' => $ktpPath,
            'selfie_photo' => $selfiePath,
            'is_verified' => 'verified',
        ]);

        return redirect()->route('profile', ['tab' => 'verification'])
            ->with('success', 'Verifikasi identitas berhasil!');
    }

    public function report(Request $request)
    {
        $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'issue_name' => 'required|string|max:255',
            'description' => 'required|string',
            'issue_photo' => 'nullable|image|max:2048',
        ], [
            'booking_id.required' => 'Kamar aktif wajib dipilih.',
            'booking_id.exists' => 'Kamar aktif tidak valid.',
            'issue_name.required' => 'Subjek permasalahan wajib diisi.',
            'issue_name.max' => 'Subjek permasalahan maksimal 255 karakter.',
            'description.required' => 'Deskripsi kerusakan wajib diisi.',
            'issue_photo.image' => 'Berkas foto bukti harus berupa gambar.',
            'issue_photo.max' => 'Ukuran foto bukti maksimal 2MB.',
        ]);

        $booking = Booking::with('room')->findOrFail($request->booking_id);
        $user = auth()->user();

        $photoPath = null;
        if ($request->hasFile('issue_photo')) {
            $photoPath = $request->file('issue_photo')->store('maintenance/photos', 'public');
        }

        MaintenanceRequest::create([
            'user_id' => $user->id,
            'booking_id' => $request->booking_id,
            'issue_name' => $request->issue_name,
            'description' => $request->description,
            'photo' => $photoPath,
            'location' => 'Kamar '.($booking->room->room_number ?? '-'),
            'status' => 'pending',
        ]);

        return redirect()->route('profile', ['tab' => 'report'])
            ->with('success', 'Laporan berhasil dikirim! Tim kami akan segera menindaklanjuti.');
    }
}
