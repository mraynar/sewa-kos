@extends('admin.layouts.app')

@section('pegawai_active', 'active')
@section('content')
  <div class="container mx-auto max-w-4xl py-10">
    <div class="flex items-start gap-8 px-4 md:px-0">
      <a href="{{ URL::previous() }}"
        class="bg-white p-3 rounded-xl shadow-sm border border-gray-100 text-gray-400 hover:text-blue-600 transition-all active:scale-90">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
          stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
          <line x1="19" y1="12" x2="5" y2="12"></line>
          <polyline points="12 19 5 12 12 5"></polyline>
        </svg>
      </a>

      <div class="flex-1">
        <div class="mb-10">
          <h2 class="text-3xl font-bold text-gray-900 tracking-tight">Tambah Akun Pegawai</h2>
          <p class="text-gray-500 mt-2 text-sm">Data ini akan digunakan pegawai untuk login ke portal staf.</p>
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

        <form action="{{ route('admin.pegawai.store') }}" method="POST"
          class="bg-white shadow-xl shadow-gray-100 rounded-[32px] p-8 md:p-12 border border-gray-50">
          @csrf

          <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10">
            <div class="space-y-2">
              <label class="text-sm font-bold text-gray-700 ml-1">Nama Panggilan</label>
              <input type="text" name="nickname" required value="{{ old('nickname') }}"
                class="w-full border border-gray-200 rounded-2xl px-6 py-4 text-sm focus:ring-4 focus:ring-blue-500/5 focus:border-blue-500 outline-none transition-all placeholder:text-gray-300"
                placeholder="Contoh: Rafi">
            </div>

            <div class="space-y-2">
              <label class="text-sm font-bold text-gray-700 ml-1">Nomor WhatsApp</label>
              <input type="text" name="phone" required value="{{ old('phone') }}"
                class="w-full border border-gray-200 rounded-2xl px-6 py-4 text-sm focus:ring-4 focus:ring-blue-500/5 focus:border-blue-500 outline-none transition-all placeholder:text-gray-300"
                placeholder="08xxxxxxxxxx">
            </div>

            <div class="space-y-2">
              <label class="text-sm font-bold text-gray-700 ml-1">Email Login</label>
              <input type="email" name="email" required value="{{ old('email') }}"
                class="w-full border border-gray-200 rounded-2xl px-6 py-4 text-sm focus:ring-4 focus:ring-blue-500/5 focus:border-blue-500 outline-none transition-all placeholder:text-gray-300"
                placeholder="pegawai@griyaasri.com">
            </div>

            <div class="space-y-2">
              <label class="text-sm font-bold text-gray-700 ml-1">Password Baru</label>
              <input type="password" name="password" required
                class="w-full border border-gray-200 rounded-2xl px-6 py-4 text-sm focus:ring-4 focus:ring-blue-500/5 focus:border-blue-500 outline-none transition-all placeholder:text-gray-300"
                placeholder="••••••••">
            </div>
          </div>

          <div class="pt-2">
            <button type="submit"
              class="w-full bg-blue-600 text-white font-bold py-5 rounded-2xl hover:bg-gray-900 transition-all shadow-xl shadow-blue-200 active:scale-[0.98]">
              Simpan Akun Pegawai
            </button>
            <div class="flex items-center justify-center gap-2 mt-8 text-gray-400">
              <div class="h-[1px] w-8 bg-gray-100"></div>
              <span class="text-[10px] font-black uppercase tracking-widest italic">Role: Pegawai Operasional</span>
              <div class="h-[1px] w-8 bg-gray-100"></div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection
