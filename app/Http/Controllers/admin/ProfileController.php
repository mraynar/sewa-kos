<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        // Ambil data admin yang sedang login
        $user = Auth::user();

        // Ambil pengaturan judul situs, jika tidak ada gunakan default
        $setting = Setting::where('key', 'site_title')->first();
        $siteTitle = $setting ? $setting->value : 'Griya Asri Kos';

        return view('admin.profile', compact('user', 'siteTitle'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'nickname' => 'required|string|max:255',
            'site_title' => 'required|string|max:255',
            'new_password' => 'nullable|string|min:6'
        ]);

        $user = Auth::user();

        $user->nickname = $request->nickname;

        if ($request->filled('new_password')) {
            $user->password = Hash::make($request->new_password);
        }
        $user->save();

        Setting::updateOrCreate(
            ['key' => 'site_title'],
            ['value' => $request->site_title]
        );

        return redirect()->route('admin.profile.index')->with('success', 'Berhasil disimpan!');
    }
}
