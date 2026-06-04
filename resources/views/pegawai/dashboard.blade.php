@extends('pegawai.layouts.app')

@section('title', 'Dashboard')
@section('dashboard_active', 'active')
@section('page_title', 'Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Welcome Banner -->
    <div class="bg-gradient-to-r from-gray-900 to-slate-800 text-white rounded-2xl p-6 shadow-lg relative overflow-hidden">
        <div class="absolute -right-16 -top-16 w-48 h-48 bg-blue-500/10 rounded-full blur-2xl"></div>
        <div class="relative z-10">
            <h3 class="text-2xl font-black md:text-3xl">Selamat Datang Kembali, {{ Auth::user()->name }}!</h3>
            <p class="text-gray-300 mt-2 text-sm md:text-base">Berikut adalah ringkasan pekerjaan Anda hari ini. Tetap semangat dan berikan pelayanan terbaik!</p>
        </div>
    </div>

    <!-- Quick Info Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Tasks Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition duration-300">
            <div class="p-6">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center space-x-4">
                        <div class="p-3 bg-blue-50 text-blue-600 rounded-xl">
                            <i class="fa-solid fa-list-check text-2xl"></i>
                        </div>
                        <div>
                            <h4 class="text-lg font-bold text-gray-800">Tugas Layanan</h4>
                            <p class="text-xs text-gray-500">Layanan tambahan kamar kos</p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-4 mb-6">
                    <div class="p-4 bg-slate-50 rounded-xl text-center">
                        <span class="block text-2xl font-black text-slate-800">{{ $totalTasks }}</span>
                        <span class="text-xs text-gray-500">Total Tugas</span>
                    </div>
                    <div class="p-4 bg-amber-50 rounded-xl text-center">
                        <span class="block text-2xl font-black text-amber-600">{{ $pendingTasks }}</span>
                        <span class="text-xs text-gray-500">Pending / Proses</span>
                    </div>
                    <div class="p-4 bg-emerald-50 rounded-xl text-center">
                        <span class="block text-2xl font-black text-emerald-600">{{ $completedTasks }}</span>
                        <span class="text-xs text-gray-500">Selesai</span>
                    </div>
                </div>

                <a href="{{ route('pegawai.tasks.index') }}" class="block w-full text-center py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-semibold shadow-sm shadow-blue-500/10 hover:shadow-blue-500/25 transition duration-250">
                    Lihat Selengkapnya <i class="fa-solid fa-arrow-right ml-2 text-xs"></i>
                </a>
            </div>
        </div>

        <!-- Maintenance Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition duration-300">
            <div class="p-6">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center space-x-4">
                        <div class="p-3 bg-orange-50 text-orange-600 rounded-xl">
                            <i class="fa-solid fa-screwdriver-wrench text-2xl"></i>
                        </div>
                        <div>
                            <h4 class="text-lg font-bold text-gray-800">Laporan Kerusakan</h4>
                            <p class="text-xs text-gray-500">Komplain perbaikan fasilitas</p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-4 mb-6">
                    <div class="p-4 bg-slate-50 rounded-xl text-center">
                        <span class="block text-2xl font-black text-slate-800">{{ $totalMaintenance }}</span>
                        <span class="text-xs text-gray-500">Total Laporan</span>
                    </div>
                    <div class="p-4 bg-amber-50 rounded-xl text-center">
                        <span class="block text-2xl font-black text-amber-600">{{ $pendingMaintenance }}</span>
                        <span class="text-xs text-gray-500">Pending / Proses</span>
                    </div>
                    <div class="p-4 bg-emerald-50 rounded-xl text-center">
                        <span class="block text-2xl font-black text-emerald-600">{{ $completedMaintenance }}</span>
                        <span class="text-xs text-gray-500">Selesai</span>
                    </div>
                </div>

                <a href="{{ route('pegawai.maintenance.index') }}" class="block w-full text-center py-3 bg-orange-600 hover:bg-orange-700 text-white rounded-xl font-semibold shadow-sm shadow-orange-500/10 hover:shadow-orange-500/25 transition duration-250">
                    Lihat Selengkapnya <i class="fa-solid fa-arrow-right ml-2 text-xs"></i>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
