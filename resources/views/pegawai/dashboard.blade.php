@extends('pegawai.layouts.app')

@section('title', 'Dashboard')
@section('dashboard_active', 'active')
@section('page_title', 'Dashboard')

@section('content')
<div class="space-y-8 text-left">
    <!-- Welcome Card -->
    <div class="bg-gradient-to-r from-gray-900 to-slate-800 text-white rounded-3xl p-8 shadow-sm relative overflow-hidden">
        <div class="absolute -right-16 -top-16 w-48 h-48 bg-blue-500/10 rounded-full blur-2xl"></div>
        <div class="relative z-10">
            <h3 class="text-2xl font-black md:text-3xl">Selamat Datang Kembali, {{ Auth::user()->name }}!</h3>
            <p class="text-gray-300 mt-2 text-sm md:text-base font-medium">Berikut adalah ringkasan pekerjaan Anda hari ini. Tetap semangat dan berikan pelayanan terbaik!</p>
        </div>
    </div>

    <!-- 3-Col Stat Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Card 1: Tugas Aktif -->
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 flex items-center justify-between">
            <div class="space-y-2">
                <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest block">Tugas Layanan Aktif</span>
                <h4 class="text-3xl font-black text-slate-800">{{ $activeTasksCount }}</h4>
            </div>
            <div class="p-4 bg-blue-50 text-blue-600 rounded-2xl">
                <i class="fa-solid fa-list-check text-2xl"></i>
            </div>
        </div>

        <!-- Card 2: Keluhan Aktif -->
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 flex items-center justify-between">
            <div class="space-y-2">
                <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest block">Keluhan Fasilitas Aktif</span>
                <h4 class="text-3xl font-black text-slate-800">{{ $activeMaintenanceCount }}</h4>
            </div>
            <div class="p-4 bg-orange-50 text-orange-600 rounded-2xl">
                <i class="fa-solid fa-screwdriver-wrench text-2xl"></i>
            </div>
        </div>

        <!-- Card 3: Pekerjaan Selesai -->
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 flex items-center justify-between">
            <div class="space-y-2">
                <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest block">Total Pekerjaan Selesai</span>
                <h4 class="text-3xl font-black text-emerald-600">{{ $completedCount }}</h4>
            </div>
            <div class="p-4 bg-emerald-50 text-emerald-600 rounded-2xl">
                <i class="fa-solid fa-circle-check text-2xl"></i>
            </div>
        </div>
    </div>

    <!-- Upcoming Tasks Section -->
    <div class="space-y-4">
        <!-- Section Title Token -->
        <div class="flex items-center gap-2">
            <div class="w-1.5 h-5 bg-blue-600 rounded-full"></div>
            <h3 class="text-lg font-black text-slate-800 uppercase tracking-tight">Tugas Layanan Aktif</h3>
        </div>

        <!-- Card Wrap -->
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
            @if(count($upcomingTasks) > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-gray-100 bg-slate-50/50">
                                <th class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-6 py-5">No.</th>
                                <th class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-6 py-5">Kamar & Tamu</th>
                                <th class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-6 py-5">Jenis Layanan</th>
                                <th class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-6 py-5">Tanggal Ditugaskan</th>
                                <th class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-6 py-5 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($upcomingTasks as $index => $task)
                                <tr class="hover:bg-blue-50/30 transition-colors">
                                    <td class="px-6 py-4 text-xs font-bold text-slate-400">{{ $upcomingTasks->firstItem() + $index }}</td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-col">
                                            <span class="font-black text-slate-800 text-sm">Kamar {{ $task->booking->room->room_number ?? '-' }}</span>
                                            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-tight">{{ $task->booking->user->name ?? '-' }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-[10px] font-black text-blue-600 bg-blue-50 px-3 py-1.5 rounded-lg border border-blue-100 uppercase">
                                            {{ $task->additionalService->service_name ?? 'Layanan' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-xs font-bold text-slate-600">
                                            {{ \Carbon\Carbon::parse($task->created_at)->translatedFormat('d M Y') }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @php
                                            $badge_class = 'bg-amber-100 text-amber-600 border border-amber-200';
                                            $status_text = 'Pending';
                                            
                                            if ($task->service_status === 'done') {
                                                $badge_class = 'bg-emerald-100 text-emerald-600 border border-emerald-200';
                                                $status_text = 'Selesai';
                                            } elseif ($task->service_status === 'on_progress') {
                                                $badge_class = 'bg-blue-100 text-blue-600 border border-blue-200';
                                                $status_text = 'On Progress';
                                            }
                                        @endphp
                                        <span class="px-3 py-1 rounded-full text-[9px] font-black uppercase {{ $badge_class }}">
                                            {{ $status_text }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if($upcomingTasks->hasPages())
                    <div class="px-6 py-4 border-t border-gray-100 bg-slate-50/50">
                        {{ $upcomingTasks->links() }}
                    </div>
                @endif
            @else
                <!-- Empty State Token -->
                <div class="flex flex-col items-center justify-center py-16">
                    <i class="fa-solid fa-folder-open text-4xl text-slate-200 mb-3"></i>
                    <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Tidak ada tugas aktif</span>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
