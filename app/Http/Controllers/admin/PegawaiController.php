<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PegawaiController extends Controller
{
    public function index()
    {
        // Mengambil data user yang hanya memiliki role 'pegawai'
        $pegawai = User::where('role', 'pegawai')->orderBy('nickname', 'asc')->get();

        // Sesuaikan nama view ini dengan nama file blade Anda (misal: admin/list-pegawai.blade.php)
        return view('admin.list-pegawai', compact('pegawai'));
    }

    public function create()
    {
        return view('admin.create-pegawai');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nickname' => 'required|string|max:255',
            'phone' => 'required|numeric|digits_between:10,15',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
        ], [
            'nickname.required' => 'Nama panggilan wajib diisi.',
            'nickname.max' => 'Nama panggilan maksimal 255 karakter.',
            'phone.required' => 'Nomor HP wajib diisi.',
            'phone.numeric' => 'Nomor HP harus berupa angka.',
            'phone.digits_between' => 'Nomor HP harus antara 10 sampai 15 digit.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email ini sudah terdaftar! Silakan gunakan email lain.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.min' => 'Kata sandi minimal 8 karakter.',
        ]);

        User::create([
            'name' => $request->nickname,
            'nickname' => $request->nickname,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => 'pegawai',
        ]);

        return redirect()->route('admin.pegawai.index')->with('success', 'Akun Pegawai berhasil dibuat!');
    }

    public function edit($id)
    {
        $pegawai = User::where('role', 'pegawai')->findOrFail($id);

        return view('admin.edit-pegawai', compact('pegawai'));
    }

    public function update(Request $request, $id)
    {
        $pegawai = User::where('role', 'pegawai')->findOrFail($id);

        $request->validate([
            'nickname' => 'required|string|max:255',
            'phone' => 'required|numeric|digits_between:10,15',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'nullable|string|min:8',
        ], [
            'nickname.required' => 'Nama panggilan wajib diisi.',
            'nickname.max' => 'Nama panggilan maksimal 255 karakter.',
            'phone.required' => 'Nomor HP wajib diisi.',
            'phone.numeric' => 'Nomor HP harus berupa angka.',
            'phone.digits_between' => 'Nomor HP harus antara 10 sampai 15 digit.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email ini sudah terdaftar! Silakan gunakan email lain.',
            'password.min' => 'Kata sandi minimal 8 karakter.',
        ]);

        $data = [
            'nickname' => $request->nickname,
            'phone' => $request->phone,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $pegawai->update($data);

        return redirect()->route('admin.pegawai.index')->with('success', 'Data akun pegawai berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $pegawai = User::where('role', 'pegawai')->findOrFail($id);
        $pegawai->delete();

        return redirect()->route('admin.pegawai.index')->with('success', 'Akun pegawai berhasil dihapus!');
    }
}
