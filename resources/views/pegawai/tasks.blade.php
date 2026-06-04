@extends('pegawai.layouts.app')

@section('title', 'Tugas Layanan')
@section('tasks_active', 'active')
@section('page_title', 'Tugas Layanan')

@section('content')
<div class="space-y-8 text-left">
    <!-- Header Title -->
    <div>
        <h1 class="text-2xl font-black text-slate-800 uppercase tracking-tight">Daftar Tugas Layanan</h1>
        <p class="text-sm text-gray-500 mt-1">Kelola dan selesaikan semua tugas layanan tambahan yang ditugaskan kepada Anda.</p>
    </div>

    <!-- Filter Section (Pill Tabs) -->
    <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 space-y-6">
        <!-- Status Filters -->
        <div class="space-y-2">
            <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest block">Status Tugas</span>
            <div class="flex flex-wrap gap-2">
                @php
                    $statusFilters = [
                        '' => 'Semua Status',
                        'pending' => 'Belum Dikerjakan',
                        'on_progress' => 'Sedang Dikerjakan',
                        'done' => 'Selesai',
                    ];
                @endphp
                @foreach ($statusFilters as $val => $label)
                    @php
                        $isActive = request('status') === $val || (request('status') === null && $val === '');
                        $url = route('pegawai.tasks.index', array_merge(request()->query(), ['status' => $val]));
                    @endphp
                    <a href="{{ $url }}" class="inline-block text-[10px] font-black uppercase tracking-wider px-4 py-2.5 rounded-2xl transition active:scale-95 {{ $isActive ? 'bg-blue-600 text-white' : 'bg-slate-50 hover:bg-slate-100 text-slate-600 border border-slate-200/50' }}">
                        {{ $label }}
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Category Filters -->
        <div class="space-y-2">
            <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest block">Kategori Layanan</span>
            <div class="flex flex-wrap gap-2">
                @php
                    $categoryFilters = [
                        '' => 'Semua Kategori',
                        'Catering' => 'Catering',
                        'Laundry' => 'Laundry',
                        'Cleaning' => 'Cleaning',
                    ];
                @endphp
                @foreach ($categoryFilters as $val => $label)
                    @php
                        $isActive = request('category') === $val || (request('category') === null && $val === '');
                        $url = route('pegawai.tasks.index', array_merge(request()->query(), ['category' => $val]));
                    @endphp
                    <a href="{{ $url }}" class="inline-block text-[10px] font-black uppercase tracking-wider px-4 py-2.5 rounded-2xl transition active:scale-95 {{ $isActive ? 'bg-blue-600 text-white' : 'bg-slate-50 hover:bg-slate-100 text-slate-600 border border-slate-200/50' }}">
                        {{ $label }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Table Section -->
    <div class="space-y-4">
        <div class="flex items-center gap-2">
            <div class="w-1.5 h-5 bg-blue-600 rounded-full"></div>
            <h3 class="text-lg font-black text-slate-800 uppercase tracking-tight">Daftar Pekerjaan</h3>
        </div>

        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
            @if (count($tasks) > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-gray-100 bg-slate-50/50">
                                <th class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-6 py-5">No.</th>
                                <th class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-6 py-5">Kamar & Tamu</th>
                                <th class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-6 py-5">Jenis Layanan</th>
                                <th class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-6 py-5 text-center">Jumlah</th>
                                <th class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-6 py-5 text-center">Status</th>
                                <th class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-6 py-5 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach ($tasks as $index => $task)
                                <tr class="hover:bg-blue-50/30 transition-colors">
                                    <td class="px-6 py-4 text-xs font-bold text-slate-400">{{ $index + 1 }}</td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-col">
                                            <span class="font-black text-slate-800 text-sm">Kamar {{ $task->booking->room->room_number ?? 'N/A' }}</span>
                                            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-tight">{{ $task->booking->user->nickname ?? ($task->booking->user->name ?? 'Unknown') }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-col">
                                            <span class="text-[10px] font-black text-blue-600 bg-blue-50 px-3 py-1.5 rounded-lg border border-blue-100 uppercase self-start">
                                                {{ $task->additionalService->service_name ?? 'Layanan' }}
                                            </span>
                                            <span class="text-[10px] font-semibold text-gray-400 mt-1">Rp {{ number_format($task->price_at_purchase, 0, ',', '.') }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-center font-bold text-slate-700 text-sm">
                                        {{ $task->quantity }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @php
                                            $badge_class = 'bg-amber-100 text-amber-600 border border-amber-200';
                                            $status_text = 'Belum Dikerjakan';
                                            
                                            if ($task->service_status === 'done') {
                                                $badge_class = 'bg-emerald-100 text-emerald-600 border border-emerald-200';
                                                $status_text = 'Selesai';
                                            } elseif ($task->service_status === 'on_progress') {
                                                $badge_class = 'bg-blue-100 text-blue-600 border border-blue-200';
                                                $status_text = 'Sedang Dikerjakan';
                                            }
                                        @endphp
                                        <span class="px-3 py-1 rounded-full text-[9px] font-black uppercase {{ $badge_class }}">
                                            {{ $status_text }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if ($task->service_status === 'done')
                                            <span class="text-xs text-emerald-600 font-bold inline-flex items-center gap-1">
                                                <i class="fa-solid fa-circle-check"></i> Selesai
                                            </span>
                                        @else
                                            <div class="flex items-center justify-center gap-2">
                                                @if ($task->service_status === 'pending' || is_null($task->service_status))
                                                    <form method="POST" action="{{ route('pegawai.tasks.update', $task->id) }}" class="inline">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="status" value="on_progress">
                                                        <button type="submit" class="bg-blue-600 hover:bg-slate-900 text-white rounded-2xl font-black uppercase text-[10px] tracking-widest active:scale-95 px-4 py-2">
                                                            Mulai
                                                        </button>
                                                    </form>
                                                @endif
                                                <form method="POST" action="{{ route('pegawai.tasks.update', $task->id) }}" class="inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="done">
                                                    <button type="submit" class="bg-emerald-600 hover:bg-slate-900 text-white rounded-2xl font-black uppercase text-[10px] tracking-widest active:scale-95 px-4 py-2">
                                                        Selesai
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <!-- Empty State -->
                <div class="flex flex-col items-center justify-center py-16">
                    <i class="fa-solid fa-folder-open text-4xl text-slate-200 mb-3"></i>
                    <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Tidak ada tugas ditemukan</span>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
