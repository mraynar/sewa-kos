@extends('pegawai.layouts.app')

@section('title', 'Profil Saya')
@section('profile_active', 'active')
@section('page_title', 'Profil Saya')

@section('content')
<div class="container mx-auto px-4 py-8 text-left">

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6 flex justify-between items-center" role="alert">
            <span class="block sm:inline font-medium">{{ session('success') }}</span>
            <button onclick="this.parentElement.style.display='none'" class="text-green-700 font-bold px-2 py-1 hover:text-green-900">&times;</button>
        </div>
    @endif

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6">
            <ul class="list-disc pl-5 text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Pengaturan Profil</h1>
            <p class="text-sm text-gray-500">Perbarui identitas pribadi dan informasi akun Anda</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 md:p-12">
        <form method="POST" action="{{ route('pegawai.profile.update') }}" class="space-y-8">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Nama Lengkap -->
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest block ml-1">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                           class="w-full border border-gray-200 rounded-2xl px-6 py-4 text-sm font-bold text-gray-700 focus:ring-4 focus:ring-blue-500/5 outline-none">
                </div>

                <!-- Nickname -->
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest block ml-1">Nama Panggilan</label>
                    <input type="text" name="nickname" value="{{ old('nickname', $user->nickname) }}" required
                           class="w-full border border-gray-200 rounded-2xl px-6 py-4 text-sm font-bold text-gray-700 focus:ring-4 focus:ring-blue-500/5 outline-none">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Email -->
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest block ml-1">Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                           class="w-full border border-gray-200 rounded-2xl px-6 py-4 text-sm font-bold text-gray-700 focus:ring-4 focus:ring-blue-500/5 outline-none">
                </div>

                <!-- Nomor HP -->
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest block ml-1">Nomor HP</label>
                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" required
                           class="w-full border border-gray-200 rounded-2xl px-6 py-4 text-sm font-bold text-gray-700 focus:ring-4 focus:ring-blue-500/5 outline-none">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Jenis Kelamin -->
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest block ml-1">Jenis Kelamin</label>
                    <select name="gender" required
                            class="w-full border border-gray-200 rounded-2xl px-6 py-4 text-sm font-bold text-gray-700 focus:ring-4 focus:ring-blue-500/5 outline-none bg-white">
                        <option value="Laki-laki" {{ old('gender', $user->gender) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="Perempuan" {{ old('gender', $user->gender) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>

                <!-- Tanggal Lahir -->
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest block ml-1">Tanggal Lahir</label>
                    <input type="date" name="birth_date" value="{{ old('birth_date', $user->birth_date) }}" required
                           class="w-full border border-gray-200 rounded-2xl px-6 py-4 text-sm font-bold text-gray-700 focus:ring-4 focus:ring-blue-500/5 outline-none">
                </div>
            </div>

            <!-- Ganti Password -->
            <div class="bg-slate-50 p-8 rounded-[32px] border border-slate-100 space-y-6">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block ml-1 text-left">Ganti Password</label>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-xs font-semibold text-gray-500 block ml-1">Password Baru</label>
                        <input type="password" name="new_password" placeholder="Kosongkan jika tidak ingin ganti"
                               class="w-full bg-white border border-slate-200 rounded-2xl px-6 py-4 text-sm font-bold text-slate-700 focus:ring-4 focus:ring-blue-500/5 outline-none">
                    </div>
                    
                    <div class="space-y-2">
                        <label class="text-xs font-semibold text-gray-500 block ml-1">Konfirmasi Password Baru</label>
                        <input type="password" name="new_password_confirmation" placeholder="Konfirmasi password baru"
                               class="w-full bg-white border border-slate-200 rounded-2xl px-6 py-4 text-sm font-bold text-slate-700 focus:ring-4 focus:ring-blue-500/5 outline-none">
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end border-t border-gray-50 pt-6">
                <button type="submit"
                        class="bg-blue-600 hover:bg-slate-900 text-white font-black py-4 px-12 rounded-2xl shadow-xl shadow-blue-200 text-xs uppercase tracking-widest transition-all active:scale-95">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
