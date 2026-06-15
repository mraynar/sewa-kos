<?php

namespace App\Http\Controllers\pegawai;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PegawaiProfileController extends Controller
{
    /**
     * Display the employee profile form.
     */
    public function index(): View
    {
        $user = Auth::user();

        return view('pegawai.profile', compact('user'));
    }

    /**
     * Update the employee profile in storage.
     */
    public function update(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'nickname' => 'required|string|max:255|unique:users,nickname,'.$user->id,
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'phone' => 'required|numeric|digits_between:10,15|unique:users,phone,'.$user->id,
            'gender' => 'required|in:Laki-laki,Perempuan',
            'birth_date' => 'required|date|before:today',
            'new_password' => 'nullable|string|min:8|confirmed',
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'name.max' => 'Nama lengkap maksimal 255 karakter.',
            'nickname.required' => 'Nama panggilan wajib diisi.',
            'nickname.max' => 'Nama panggilan maksimal 255 karakter.',
            'nickname.unique' => 'Nama panggilan sudah digunakan.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.max' => 'Email maksimal 255 karakter.',
            'email.unique' => 'Email sudah digunakan.',
            'phone.required' => 'Nomor HP wajib diisi.',
            'phone.numeric' => 'Nomor HP harus berupa angka.',
            'phone.digits_between' => 'Nomor HP harus antara 10 sampai 15 digit.',
            'phone.unique' => 'Nomor HP sudah digunakan.',
            'gender.required' => 'Jenis kelamin wajib dipilih.',
            'gender.in' => 'Jenis kelamin tidak valid.',
            'birth_date.required' => 'Tanggal lahir wajib diisi.',
            'birth_date.date' => 'Format tanggal lahir tidak valid.',
            'birth_date.before' => 'Tanggal lahir harus sebelum hari ini.',
            'new_password.min' => 'Kata sandi baru minimal 8 karakter.',
            'new_password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $user->update([
            'name' => $request->name,
            'nickname' => $request->nickname,
            'email' => $request->email,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'birth_date' => $request->birth_date,
        ]);

        if ($request->filled('new_password')) {
            $user->update([
                'password' => Hash::make($request->new_password),
            ]);
        }

        return redirect()->route('pegawai.profile.index')->with('success', 'Profil berhasil diperbarui!');
    }
}
