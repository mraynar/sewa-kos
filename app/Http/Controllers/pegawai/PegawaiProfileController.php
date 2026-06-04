<?php

namespace App\Http\Controllers\pegawai;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
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
    public function update(Request $request): \Illuminate\Http\RedirectResponse
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'nickname' => 'required|string|max:255|unique:users,nickname,'.$user->id,
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'phone' => 'required|string|max:15|unique:users,phone,'.$user->id,
            'gender' => 'required|in:Laki-laki,Perempuan',
            'birth_date' => 'required|date|before:today',
            'new_password' => 'nullable|string|min:6|confirmed',
        ], [
            'nickname.unique' => 'Nama panggilan sudah digunakan.',
            'email.unique' => 'Email sudah digunakan.',
            'phone.unique' => 'Nomor HP sudah digunakan.',
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
