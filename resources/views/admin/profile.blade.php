@extends('admin.layouts.app')

@section('profile_active', 'active')
@section('content')
  <div class="container mx-auto px-4 py-8 text-left">

    @if (session('success'))
      <div
        class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6 flex justify-between items-center"
        role="alert">
        <span class="block sm:inline font-medium">{{ session('success') }}</span>
        <button onclick="this.parentElement.style.display='none'"
          class="text-green-700 font-bold px-2 py-1 hover:text-green-900">&times;</button>
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
        <h1 class="text-2xl font-bold text-gray-900">Profile Settings</h1>
        <p class="text-sm text-gray-500">Update akun dan identitas website</p>
      </div>

      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" onclick="return confirm('Keluar?')"
          class="bg-red-50 text-red-600 px-6 py-2 rounded-xl font-bold text-sm border border-red-100 shadow-sm hover:bg-red-100 transition-colors">
          <i class="fas fa-sign-out-alt mr-2"></i> Sign Out
        </button>
      </form>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 md:p-12">
      <form method="POST" action="{{ route('admin.profile.update') }}" class="space-y-8">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
          <div class="space-y-2">
            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest block ml-1">Email (Read
              Only)</label>
            <input type="text" value="{{ $user->email }}" disabled
              class="w-full bg-gray-50 border border-gray-200 rounded-2xl px-6 py-4 text-sm font-bold text-gray-400 cursor-not-allowed">
          </div>
          <div class="space-y-2">
            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest block ml-1">Nickname</label>
            <input type="text" name="nickname" value="{{ old('nickname', $user->nickname) }}" required
              class="w-full border rounded-2xl px-6 py-4 text-sm font-bold text-gray-700 focus:ring-4 focus:ring-blue-500/5 outline-none {{ $errors->has('nickname') ? 'border-red-400' : 'border-gray-200' }}">
            @error('nickname')
              <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
          </div>
        </div>

        <div class="space-y-2">
          <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest block ml-1">Site Title</label>
          <input type="text" name="site_title" value="{{ old('site_title', $siteTitle) }}" required
            class="w-full border rounded-2xl px-6 py-4 text-sm font-bold text-gray-700 focus:ring-4 focus:ring-blue-500/5 outline-none {{ $errors->has('site_title') ? 'border-red-400' : 'border-gray-200' }}">
          @error('site_title')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
          @enderror
        </div>

        <div class="bg-slate-50 p-8 rounded-[32px] border border-slate-100">
          <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block ml-1 mb-4 text-left">Ganti
            Password</label>
          <input type="password" name="new_password" placeholder="Isi hanya jika ingin mengganti password"
            class="w-full bg-white border rounded-2xl px-6 py-4 text-sm font-bold text-slate-700 focus:ring-4 focus:ring-blue-500/5 outline-none {{ $errors->has('new_password') ? 'border-red-400' : 'border-slate-200' }}">
          @error('new_password')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
          @enderror
        </div>

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
