@extends('penyewa.layouts.app')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-8 md:p-12 text-center">
            <div class="w-24 h-24 bg-slate-100 rounded-2xl flex items-center justify-center text-primary mx-auto mb-6">
                <i class="fas fa-user-graduate text-4xl"></i>
            </div>

            <h1 class="text-2xl font-black text-slate-900 mb-2">{{ Auth::user()->name }}</h1>
            <p class="text-slate-500 font-bold text-sm mb-8 italic">{{ Auth::user()->email }}</p>

            <div class="grid grid-cols-1 gap-4 max-w-xs mx-auto">
                <button class="w-full bg-slate-50 text-slate-600 font-bold py-4 rounded-2xl border border-slate-100 hover:bg-slate-100 transition-all active:scale-95">
                    Edit Profil
                </button>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full bg-red-50 text-red-500 font-black py-4 rounded-2xl border border-red-100 hover:bg-red-500 hover:text-white transition-all">
                        <i class="fas fa-sign-out-alt mr-2"></i> Keluar Akun
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
