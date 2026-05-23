<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string'],
            'password' => ['required'],
        ]);

        $fieldType = filter_var($request->email, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';

        if (Auth::attempt([$fieldType => $request->email, 'password' => $request->password])) {
            $request->session()->regenerate();
            $user = Auth::user();

            if ($user->isAdmin()) {
                return redirect()->route('admin.dashboard');
            }
            if ($user->isPegawai()) {
                return redirect()->route('pegawai.dashboard');
            }
            return redirect()->route('home');
        }

        return back()->withErrors([
            'email' => 'Nomor HP/Email atau kata sandi salah!',
        ])->withInput($request->only('email'));
    }

    public function registerIndex()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nickname' => 'required|string|max:255|unique:users,nickname',
            'email'    => 'required|string|email|max:255|unique:users,email',
            'phone'    => 'required|string|max:15|unique:users,phone',
            'password' => 'required|string|min:8',
            'confirm_password' => 'required|same:password',
        ], [
            'nickname.unique' => 'Nama panggilan ini sudah digunakan.',
            'email.unique'    => 'Email ini sudah terdaftar.',
            'phone.unique'    => 'Nomor telepon ini sudah terdaftar.',
            'confirm_password.same' => 'Konfirmasi kata sandi tidak cocok!',
        ]);

        User::create([
            'nickname' => $request->nickname,
            'name'     => $request->nickname,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'password' => Hash::make($request->password),
            'role'     => 'penyewa',
        ]);

        return redirect()->route('login')->with('success', 'Pendaftaran berhasil! Silakan masuk.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
