@extends('penyewa.layouts.app')

@section('content')
    <div class="bg-slate-50 min-h-screen py-10">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

                <div class="lg:col-span-3 space-y-4">

                    <div class="bg-white rounded-2xl border border-slate-200 p-5 flex items-center gap-4">
                        <div
                            class="w-12 h-12 bg-slate-100 rounded-xl flex items-center justify-center text-slate-500 flex-shrink-0 overflow-hidden">
                            @if ($user->avatar)
                                <img src="{{ $user->avatar }}" class="w-full h-full object-cover" alt="Avatar">
                            @else
                                <i class="fas fa-user text-base"></i>
                            @endif
                        </div>
                        <div class="min-w-0">
                            <p class="text-sm font-bold text-slate-900 truncate">{{ $user->nickname }}</p>
                            <p class="text-xs text-slate-400 capitalize mt-0.5">{{ $user->role }}</p>
                            @if ($user->is_verified === 'verified')
                                <span
                                    class="inline-flex items-center gap-1 mt-1.5 text-[10px] font-semibold px-2 py-0.5 bg-emerald-50 text-emerald-600 rounded-md border border-emerald-100">
                                    <i class="fas fa-check-circle text-[9px]"></i> Verified
                                </span>
                            @elseif($user->is_verified === 'pending')
                                <span
                                    class="inline-flex items-center gap-1 mt-1.5 text-[10px] font-semibold px-2 py-0.5 bg-amber-50 text-amber-600 rounded-md border border-amber-100">
                                    <i class="fas fa-clock text-[9px]"></i> Pending
                                </span>
                            @else
                                <span
                                    class="inline-flex items-center gap-1 mt-1.5 text-[10px] font-semibold px-2 py-0.5 bg-slate-100 text-slate-400 rounded-md">
                                    <i class="fas fa-id-card text-[9px]"></i> Belum Verifikasi
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
                        <nav class="p-1.5 space-y-0.5">
                            @php
                                $navItems = [
                                    ['tab' => 'edit', 'icon' => 'fa-user', 'label' => 'Edit Profile'],
                                    ['tab' => 'history', 'icon' => 'fa-clock-rotate-left', 'label' => 'Rental History'],
                                    ['tab' => 'verification', 'icon' => 'fa-id-card', 'label' => 'Verification'],
                                    [
                                        'tab' => 'report',
                                        'icon' => 'fa-triangle-exclamation',
                                        'label' => 'Lapor Masalah',
                                    ],
                                    ['tab' => 'password', 'icon' => 'fa-lock', 'label' => 'Change Password'],
                                ];
                            @endphp

                            @foreach ($navItems as $item)
                                <a href="{{ route('profile', ['tab' => $item['tab']]) }}"
                                    class="flex items-center justify-between px-3 py-2.5 rounded-lg transition-all duration-200
                                  {{ $tab === $item['tab'] ? 'bg-primary text-white' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50' }}">
                                    <div class="flex items-center gap-3">
                                        <i class="fas {{ $item['icon'] }} text-sm w-4 text-center"></i>
                                        <span class="text-sm font-semibold">{{ $item['label'] }}</span>
                                    </div>
                                    @if ($tab === $item['tab'])
                                        <i class="fas fa-chevron-right text-[10px] opacity-60"></i>
                                    @endif
                                </a>
                            @endforeach

                            <div class="my-1 mx-2 border-t border-slate-100"></div>

                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-red-400 hover:bg-red-50 hover:text-red-500 transition-all duration-200">
                                    <i class="fas fa-arrow-right-from-bracket text-sm w-4 text-center"></i>
                                    <span class="text-sm font-semibold">Sign Out</span>
                                </button>
                            </form>
                        </nav>
                    </div>
                </div>

                <div class="lg:col-span-9">
                    <div class="bg-white rounded-2xl border border-slate-200 p-8 min-h-[600px]">

                        @if (session('success'))
                            <div
                                class="mb-6 p-4 rounded-xl flex items-center gap-3 bg-emerald-50 text-emerald-700 border border-emerald-100">
                                <i class="fas fa-check-circle text-sm"></i>
                                <p class="text-sm font-semibold">{{ session('success') }}</p>
                            </div>
                        @endif

                        @if ($errors->any() && !$errors->has('current_password') && !$errors->has('new_password'))
                            <div
                                class="mb-6 p-4 rounded-xl flex items-center gap-3 bg-red-50 text-red-600 border border-red-100">
                                <i class="fas fa-exclamation-circle text-sm"></i>
                                <p class="text-sm font-semibold">{{ $errors->first() }}</p>
                            </div>
                        @endif

                        @switch($tab)
                            @case('history')
                                @include('penyewa.profile.history')
                            @break

                            @case('verification')
                                @include('penyewa.profile.verification')
                            @break

                            @case('report')
                                @include('penyewa.profile.report')
                            @break

                            @case('password')
                                @include('penyewa.profile.password')
                            @break

                            @default
                                @include('penyewa.profile.edit')
                        @endswitch

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
