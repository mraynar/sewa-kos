@extends('pegawai.layouts.app')

@section('title', 'Profil Saya')
@section('profile_active', 'active')
@section('page_title', 'Profil Saya')

@section('content')
<div class="space-y-8 text-left max-w-4xl mx-auto">
    <!-- Header Title -->
    <div>
        <h1 class="text-2xl font-black text-slate-800 uppercase tracking-tight">Pengaturan Profil</h1>
        <p class="text-sm text-gray-500 mt-1">Perbarui identitas pribadi, informasi kontak, dan kata sandi akun Anda.</p>
    </div>

    <!-- Success Feedback Banner -->
    @if (session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-3xl p-5 mb-6 flex items-center justify-between shadow-sm animate-fade-in">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-emerald-500/10 text-emerald-600 rounded-xl">
                    <i class="fa-solid fa-circle-check text-base"></i>
                </div>
                <span class="text-xs font-black uppercase tracking-wider">{{ session('success') }}</span>
            </div>
            <button onclick="this.parentElement.style.display='none'" class="text-emerald-500 hover:text-emerald-700 transition active:scale-90">
                <i class="fa-solid fa-xmark text-sm"></i>
            </button>
        </div>
    @endif

    <!-- Error Feedback Banner -->
    @if ($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-800 rounded-3xl p-5 mb-6 shadow-sm animate-fade-in">
            <div class="flex items-start gap-3">
                <div class="p-2 bg-red-500/10 text-red-600 rounded-xl mt-0.5">
                    <i class="fa-solid fa-triangle-exclamation text-base"></i>
                </div>
                <div class="flex-1 space-y-1">
                    <span class="text-xs font-black uppercase tracking-wider block">Terjadi Kesalahan:</span>
                    <ul class="list-disc pl-4 text-xs font-semibold space-y-0.5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <!-- Avatar Card -->
    <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 flex flex-col md:flex-row items-center gap-6">
        <div class="w-24 h-24 rounded-full bg-gradient-to-tr from-blue-600 to-indigo-600 text-white flex items-center justify-center font-black text-3xl shadow-md border-4 border-slate-50 uppercase">
            {{ substr($user->name, 0, 2) }}
        </div>
        <div class="text-center md:text-left space-y-1">
            <h3 class="text-xl font-black text-slate-800 uppercase tracking-tight">{{ $user->name }}</h3>
            <span class="inline-block text-[9px] font-black bg-blue-50 text-blue-600 px-3 py-1 rounded-full border border-blue-100 uppercase">
                Pegawai Kos
            </span>
            <p class="text-xs text-gray-400 font-semibold mt-1">{{ $user->email }}</p>
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 md:p-10">
        <form method="POST" action="{{ route('pegawai.profile.update') }}" class="space-y-8">
            @csrf
            @method('PUT')

            <!-- Section Title -->
            <div class="flex items-center gap-2">
                <div class="w-1.5 h-5 bg-blue-600 rounded-full"></div>
                <h3 class="text-lg font-black text-slate-800 uppercase tracking-tight">Informasi Pribadi</h3>
            </div>

            <!-- 2-Col Grid Form -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nama Lengkap -->
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest block ml-1">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required placeholder="Nama Lengkap Anda"
                           class="w-full bg-slate-50 border rounded-2xl px-5 py-4 text-sm font-bold text-slate-800 placeholder-slate-400 focus:bg-white focus:border-blue-600 focus:ring-4 focus:ring-blue-500/10 outline-none transition duration-200 {{ $errors->has('name') ? 'border-red-400' : 'border-transparent' }}">
                    @error('name')
                        <p class="text-red-500 text-sm mt-1 ml-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nickname -->
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest block ml-1">Nama Panggilan</label>
                    <input type="text" name="nickname" value="{{ old('nickname', $user->nickname) }}" required placeholder="Nama Panggilan"
                           class="w-full bg-slate-50 border rounded-2xl px-5 py-4 text-sm font-bold text-slate-800 placeholder-slate-400 focus:bg-white focus:border-blue-600 focus:ring-4 focus:ring-blue-500/10 outline-none transition duration-200 {{ $errors->has('nickname') ? 'border-red-400' : 'border-transparent' }}">
                    @error('nickname')
                        <p class="text-red-500 text-sm mt-1 ml-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest block ml-1">Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required placeholder="Alamat Email"
                           class="w-full bg-slate-50 border rounded-2xl px-5 py-4 text-sm font-bold text-slate-800 placeholder-slate-400 focus:bg-white focus:border-blue-600 focus:ring-4 focus:ring-blue-500/10 outline-none transition duration-200 {{ $errors->has('email') ? 'border-red-400' : 'border-transparent' }}">
                    @error('email')
                        <p class="text-red-500 text-sm mt-1 ml-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nomor HP -->
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest block ml-1">Nomor HP</label>
                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" required placeholder="Nomor Telepon Akif"
                           class="w-full bg-slate-50 border rounded-2xl px-5 py-4 text-sm font-bold text-slate-800 placeholder-slate-400 focus:bg-white focus:border-blue-600 focus:ring-4 focus:ring-blue-500/10 outline-none transition duration-200 {{ $errors->has('phone') ? 'border-red-400' : 'border-transparent' }}">
                    @error('phone')
                        <p class="text-red-500 text-sm mt-1 ml-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Jenis Kelamin -->
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest block ml-1">Jenis Kelamin</label>
                    <select name="gender" required
                            class="w-full bg-slate-50 border border-transparent rounded-2xl px-5 py-4 text-sm font-bold text-slate-800 focus:bg-white focus:border-blue-600 focus:ring-4 focus:ring-blue-500/10 outline-none transition duration-200 appearance-none bg-[url('data:image/svg+xml;charset=utf-8,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%2020%2020%22%20fill%3D%22none%22%3E%3Cpath%20d%3D%22M7%209l3%203%203-3%22%20stroke%3D%22%236b7280%22%20stroke-width%3D%221.5%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%2F%3E%3C%2Fsvg%3E')] bg-[length:1.25rem_1.25rem] bg-[right_1.25rem_center] bg-no-repeat">
                        <option value="Laki-laki" {{ old('gender', $user->gender) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="Perempuan" {{ old('gender', $user->gender) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    @error('gender')
                        <p class="text-red-500 text-sm mt-1 ml-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tanggal Lahir -->
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest block ml-1">Tanggal Lahir</label>
                    <input type="date" name="birth_date" value="{{ old('birth_date', $user->birth_date) }}" required
                           class="w-full bg-slate-50 border rounded-2xl px-5 py-4 text-sm font-bold text-slate-800 focus:bg-white focus:border-blue-600 focus:ring-4 focus:ring-blue-500/10 outline-none transition duration-200 {{ $errors->has('birth_date') ? 'border-red-400' : 'border-transparent' }}">
                    @error('birth_date')
                        <p class="text-red-500 text-sm mt-1 ml-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Ganti Password Section -->
            <div class="bg-slate-50/50 p-6 md:p-8 rounded-[32px] border border-slate-100/50 space-y-6">
                <!-- Section Title -->
                <div class="flex items-center gap-2">
                    <div class="w-1.5 h-5 bg-blue-600 rounded-full"></div>
                    <h3 class="text-sm font-black text-slate-800 uppercase tracking-tight">Keamanan Akun</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest block ml-1">Password Baru</label>
                        <input type="password" name="new_password" placeholder="Biarkan kosong jika tidak ganti"
                               class="w-full bg-white border rounded-2xl px-5 py-4 text-sm font-bold text-slate-800 placeholder-slate-400 focus:border-blue-600 focus:ring-4 focus:ring-blue-500/10 outline-none transition duration-200 {{ $errors->has('new_password') ? 'border-red-400' : 'border-slate-200' }}">
                        @error('new_password')
                            <p class="text-red-500 text-sm mt-1 ml-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest block ml-1">Konfirmasi Password Baru</label>
                        <input type="password" name="new_password_confirmation" placeholder="Ulangi password baru"
                               class="w-full bg-white border border-slate-200 rounded-2xl px-5 py-4 text-sm font-bold text-slate-800 placeholder-slate-400 focus:border-blue-600 focus:ring-4 focus:ring-blue-500/10 outline-none transition duration-200">
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end border-t border-gray-50 pt-6">
                <button type="submit"
                        class="bg-blue-600 hover:bg-slate-900 text-white font-black py-4 px-12 rounded-2xl shadow-xl shadow-blue-500/10 text-[10px] uppercase tracking-widest transition-all active:scale-95">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

    <!-- Sign Out Card -->
    <div class="bg-red-50/50 rounded-3xl p-8 border border-red-100/50 flex flex-col md:flex-row items-center justify-between gap-6">
        <div class="space-y-1 text-center md:text-left">
            <h4 class="font-black text-red-800 uppercase tracking-tight text-base">Keluar dari Akun</h4>
            <p class="text-xs text-red-600/70 font-semibold">Pastikan semua pekerjaan Anda hari ini sudah tersimpan dan dilaporkan.</p>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="bg-red-600 hover:bg-slate-900 text-white rounded-2xl font-black uppercase text-[10px] tracking-widest active:scale-95 px-8 py-4 transition shadow-md shadow-red-100">
                <i class="fas fa-sign-out-alt mr-2"></i> Keluar
            </button>
        </form>
    </div>
</div>
@endsection
