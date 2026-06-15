@extends('admin.layouts.app')

@section('pegawai_active', 'active')
@section('content')
  <div class="container mx-auto max-w-4xl py-10">
    <div class="flex items-start gap-8 px-4 md:px-0">

      <a href="{{ URL::previous() }}"
        class="bg-white p-3 rounded-xl shadow-sm border border-gray-100 text-gray-400 hover:text-blue-600 transition-all">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
          stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
          <line x1="19" y1="12" x2="5" y2="12"></line>
          <polyline points="12 19 5 12 12 5"></polyline>
        </svg>
      </a>

      <div class="flex-1">
        <div class="mb-10">
          <h2 class="text-3xl font-bold text-gray-900 tracking-tight">Edit Akun Pegawai</h2>
          <p class="text-gray-500 mt-2 text-sm">Perbarui informasi profil atau akses login staf operasional.</p>
        </div>

        @if ($errors->any())
          <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6">
            <ul class="list-disc pl-5 text-sm">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <form method="POST" action="{{ route('admin.pegawai.update', $pegawai->id) }}"
          class="bg-white shadow-xl shadow-gray-100 rounded-[32px] p-8 md:p-12 border border-gray-50">
          @csrf
          @method('PUT')

          <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10">

            <div class="space-y-2">
              <label class="text-sm font-bold text-gray-700 ml-1">Nama Panggilan</label>
              <input type="text" name="nickname" required
                class="w-full border border-gray-200 rounded-2xl px-6 py-4 text-sm focus:ring-4 focus:ring-blue-500/5 focus:border-blue-500 outline-none transition-all
                @error('nickname') border-red-300 @enderror"
                value="{{ old('nickname', $pegawai->nickname) }}">
              @error('nickname')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
              @enderror
            </div>

            <div class="space-y-2">
              <label class="text-sm font-bold text-gray-700 ml-1">Nomor WhatsApp</label>
              <input type="text" name="phone" required
                class="w-full border border-gray-200 rounded-2xl px-6 py-4 text-sm focus:ring-4 focus:ring-blue-500/5 focus:border-blue-500 outline-none transition-all
                @error('phone') border-red-300 @enderror"
                value="{{ old('phone', $pegawai->phone) }}">
              @error('phone')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
              @enderror
            </div>

            <div class="space-y-2">
              <label class="text-sm font-bold text-gray-700 ml-1">Email Login</label>
              <input type="email" name="email" required
                class="w-full border border-gray-200 rounded-2xl px-6 py-4 text-sm focus:ring-4 focus:ring-blue-500/5 focus:border-blue-500 outline-none transition-all
                @error('email') border-red-300 @enderror"
                value="{{ old('email', $pegawai->email) }}">
              @error('email')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
              @enderror
            </div>

            <div class="space-y-2">
              <label class="text-sm font-bold text-gray-700 ml-1">Reset Password (Opsional)</label>
              <input type="password" name="password"
                class="w-full border border-gray-200 rounded-2xl px-6 py-4 text-sm focus:ring-4 focus:ring-blue-500/5 focus:border-blue-500 outline-none transition-all placeholder:text-gray-300
                @error('password') border-red-300 @enderror"
                placeholder="Kosongkan jika tidak ingin ganti">
              @error('password')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
              @enderror
            </div>

          </div>

          <div class="pt-2">
            <button type="submit"
              class="w-full bg-blue-600 text-white font-bold py-5 rounded-2xl hover:bg-gray-900 transition-all shadow-xl shadow-blue-200">
              Simpan Perubahan
            </button>
            <p class="text-center text-[10px] text-gray-400 mt-8 uppercase tracking-widest font-black italic">
              ID Pegawai: #{{ $pegawai->id }} — Terdaftar sejak
              {{ $pegawai->created_at ? $pegawai->created_at->translatedFormat('d M Y') : '-' }}
            </p>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection
