<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Mail\OtpMail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    public function showForgotForm()
    {
        return view('auth.forgot-password');
    }

    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.exists' => 'Email ini tidak terdaftar di sistem kami.',
        ]);

        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        DB::table('password_reset_tokens')->where('email', $request->email)->delete();
        DB::table('password_reset_tokens')->insert([
            'email' => $request->email,
            'token' => Hash::make($otp),
            'created_at' => Carbon::now(),
        ]);

        Mail::to($request->email)->send(new OtpMail($otp));

        return redirect()->route('password.otp', ['email' => $request->email])
            ->with('success', 'Kode OTP telah dikirim ke email Anda.');
    }

    public function showOtpForm(Request $request)
    {
        if (! $request->email) {
            return redirect()->route('password.request');
        }

        return view('auth.verify-otp', ['email' => $request->email]);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|string|size:6',
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'otp.required' => 'Kode OTP wajib diisi.',
            'otp.string' => 'Kode OTP harus berupa string.',
            'otp.size' => 'Kode OTP harus tepat 6 karakter.',
        ]);

        $record = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        if (! $record) {
            return back()->withErrors(['otp' => 'Kode OTP tidak valid atau sudah kadaluarsa.'])->withInput();
        }

        if (Carbon::parse($record->created_at)->addMinutes(15)->isPast()) {
            DB::table('password_reset_tokens')->where('email', $request->email)->delete();

            return back()->withErrors(['otp' => 'Kode OTP sudah kadaluarsa. Minta kode baru.'])->withInput();
        }

        if (! Hash::check($request->otp, $record->token)) {
            return back()->withErrors(['otp' => 'Kode OTP yang Anda masukkan salah.'])->withInput();
        }

        $resetToken = Str::random(64);
        DB::table('password_reset_tokens')->where('email', $request->email)->update([
            'token' => Hash::make($resetToken),
        ]);

        return redirect()->route('password.reset.form', [
            'email' => $request->email,
            'token' => $resetToken,
        ]);
    }

    public function showResetForm(Request $request)
    {
        if (! $request->email || ! $request->token) {
            return redirect()->route('password.request');
        }

        return view('auth.reset-password', [
            'email' => $request->email,
            'token' => $request->token,
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'token' => 'required',
            'password' => 'required|min:8|confirmed',
            'password_confirmation' => 'required',
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.exists' => 'Email ini tidak terdaftar di sistem kami.',
            'token.required' => 'Token reset wajib diisi.',
            'password.required' => 'Kata sandi baru wajib diisi.',
            'password.min' => 'Kata sandi minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
            'password_confirmation.required' => 'Konfirmasi kata sandi wajib diisi.',
        ]);

        $record = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        if (! $record || ! Hash::check($request->token, $record->token)) {
            return back()->withErrors(['token' => 'Link reset tidak valid. Mulai ulang prosesnya.']);
        }

        User::where('email', $request->email)->update([
            'password' => Hash::make($request->password),
        ]);

        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect()->route('login')->with('success', 'Kata sandi berhasil diperbarui! Silakan masuk.');
    }
}
