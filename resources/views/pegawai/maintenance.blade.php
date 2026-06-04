@extends('pegawai.layouts.app')

@section('title', 'Laporan Kerusakan')
@section('maintenance_active', 'active')
@section('page_title', 'Laporan Kerusakan')

@section('content')
<div class="space-y-8 text-left">
    <!-- Header Title -->
    <div>
        <h1 class="text-2xl font-black text-slate-800 uppercase tracking-tight">Laporan Kerusakan & Rutin</h1>
        <p class="text-sm text-gray-500 mt-1">Kelola perbaikan kerusakan fasilitas dari penyewa serta pemeliharaan rutin kos.</p>
    </div>

    <!-- Tab Switcher & Status Filter Wrapper -->
    <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 space-y-6">
        <!-- Tab Switcher -->
        <div class="flex border-b border-gray-100">
            <a href="{{ route('pegawai.maintenance.index', array_merge(request()->query(), ['tab' => 'kerusakan'])) }}" class="py-4 px-6 border-b-2 font-black uppercase text-[10px] tracking-widest transition {{ $activeTab === 'kerusakan' ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-400 hover:text-slate-800' }}">
                <i class="fa-solid fa-screwdriver-wrench mr-2"></i> Laporan Kerusakan
            </a>
            <a href="{{ route('pegawai.maintenance.index', array_merge(request()->query(), ['tab' => 'rutin'])) }}" class="py-4 px-6 border-b-2 font-black uppercase text-[10px] tracking-widest transition {{ $activeTab === 'rutin' ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-400 hover:text-slate-800' }}">
                <i class="fa-solid fa-calendar-check mr-2"></i> Pemeliharaan Rutin
            </a>
        </div>

        <!-- Status Filter (Pill Tabs) -->
        <div class="space-y-2">
            <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest block">Filter Status</span>
            <div class="flex flex-wrap gap-2">
                @php
                    $statusFilters = [
                        '' => 'Semua Status',
                        'pending' => 'Pending',
                        'on_progress' => 'Sedang Dikerjakan',
                        'done' => 'Selesai',
                    ];
                @endphp
                @foreach ($statusFilters as $val => $label)
                    @php
                        $isActive = request('status') === $val || (request('status') === null && $val === '');
                        $url = route('pegawai.maintenance.index', array_merge(request()->query(), ['status' => $val]));
                    @endphp
                    <a href="{{ $url }}" class="inline-block text-[10px] font-black uppercase tracking-wider px-4 py-2.5 rounded-2xl transition active:scale-95 {{ $isActive ? 'bg-blue-600 text-white' : 'bg-slate-50 hover:bg-slate-100 text-slate-600 border border-slate-200/50' }}">
                        {{ $label }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Active Content Area -->
    <div class="space-y-4">
        <div class="flex items-center gap-2">
            <div class="w-1.5 h-5 bg-blue-600 rounded-full"></div>
            <h3 class="text-lg font-black text-slate-800 uppercase tracking-tight">
                {{ $activeTab === 'rutin' ? 'Pemeliharaan Rutin' : 'Komplain Kerusakan' }}
            </h3>
        </div>

        @if (count($reports) > 0)
            @if ($activeTab === 'rutin')
                <!-- Routine Card Grid -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach ($reports as $report)
                        <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 flex flex-col justify-between space-y-4">
                            <div class="space-y-3">
                                <div class="flex items-center justify-between">
                                    <span class="text-[9px] font-black bg-blue-50 text-blue-600 px-2.5 py-1 rounded-lg border border-blue-100 uppercase">
                                        Rutin
                                    </span>
                                    @php
                                        $badge_class = 'bg-amber-100 text-amber-600 border border-amber-200';
                                        if ($report->status === 'done') {
                                            $badge_class = 'bg-emerald-100 text-emerald-600 border border-emerald-200';
                                        } elseif ($report->status === 'on_progress') {
                                            $badge_class = 'bg-blue-100 text-blue-600 border border-blue-200';
                                        }
                                    @endphp
                                    <span class="px-2.5 py-0.5 rounded-full text-[8px] font-black uppercase {{ $badge_class }}">
                                        {{ str_replace('_', ' ', $report->status) }}
                                    </span>
                                </div>
                                
                                <div>
                                    <h4 class="font-black text-slate-800 text-base leading-tight">{{ $report->issue_name }}</h4>
                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-tight mt-1"><i class="fa-solid fa-location-dot mr-1"></i> {{ $report->location }}</p>
                                </div>
                                
                                <p class="text-xs text-gray-500 font-medium leading-relaxed">{{ $report->description }}</p>
                            </div>
                            
                            <div class="pt-4 border-t border-gray-100 flex items-center justify-between">
                                <span class="text-[9px] font-black text-gray-400 uppercase tracking-widest">
                                    {{ \Carbon\Carbon::parse($report->created_at)->translatedFormat('d M Y') }}
                                </span>
                                
                                @if ($report->status === 'done')
                                    <span class="text-xs text-emerald-600 font-bold inline-flex items-center gap-1">
                                        <i class="fa-solid fa-circle-check"></i> Selesai
                                    </span>
                                @else
                                    <div class="flex gap-2">
                                        @if ($report->status === 'pending')
                                            <form method="POST" action="{{ route('pegawai.maintenance.update', $report->id) }}" class="inline">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="on_progress">
                                                <button type="submit" class="bg-blue-600 hover:bg-slate-900 text-white rounded-2xl font-black uppercase text-[9px] tracking-widest active:scale-95 px-3 py-1.5">
                                                    Proses
                                                </button>
                                            </form>
                                        @endif
                                        <form method="POST" action="{{ route('pegawai.maintenance.update', $report->id) }}" class="inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="done">
                                            <button type="submit" class="bg-emerald-600 hover:bg-slate-900 text-white rounded-2xl font-black uppercase text-[9px] tracking-widest active:scale-95 px-3 py-1.5">
                                                Selesai
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- Damage Report Table -->
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b border-gray-100 bg-slate-50/50">
                                    <th class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-6 py-5">Lokasi & Kamar</th>
                                    <th class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-6 py-5">Pelapor</th>
                                    <th class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-6 py-5">Keluhan</th>
                                    <th class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-6 py-5 text-center">Foto</th>
                                    <th class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-6 py-5 text-center">Status</th>
                                    <th class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-6 py-5 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach ($reports as $report)
                                    <tr class="hover:bg-blue-50/30 transition-colors">
                                        <td class="px-6 py-4">
                                            <div class="flex flex-col">
                                                <span class="font-black text-slate-800 text-sm">{{ $report->location }}</span>
                                                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-tight mt-0.5">Kamar: {{ $report->booking->room->room_number ?? 'N/A' }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-xs font-bold text-slate-600 uppercase">
                                            {{ $report->user->nickname ?? ($report->user->name ?? 'Unknown') }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex flex-col">
                                                <span class="font-black text-slate-800 text-sm">{{ $report->issue_name }}</span>
                                                <p class="text-xs text-gray-500 truncate max-w-[250px] font-medium mt-1">{{ $report->description }}</p>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            @if ($report->photo)
                                                <button onclick="openPhotoModal('{{ asset('assets/img/reports/' . $report->photo) }}')" class="p-2 bg-blue-50 text-blue-600 rounded-xl hover:bg-blue-100 transition active:scale-95">
                                                    <i class="fas fa-image text-base"></i>
                                                </button>
                                            @else
                                                <span class="text-[10px] font-black text-gray-300 uppercase tracking-wider italic">No Photo</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            @php
                                                $badge_class = 'bg-amber-100 text-amber-600 border border-amber-200';
                                                if ($report->status === 'done') {
                                                    $badge_class = 'bg-emerald-100 text-emerald-600 border border-emerald-200';
                                                } elseif ($report->status === 'on_progress') {
                                                    $badge_class = 'bg-blue-100 text-blue-600 border border-blue-200';
                                                }
                                            @endphp
                                            <span class="px-3 py-1 rounded-full text-[9px] font-black uppercase {{ $badge_class }}">
                                                {{ str_replace('_', ' ', $report->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            @if ($report->status === 'done')
                                                <span class="text-xs text-emerald-600 font-bold inline-flex items-center gap-1">
                                                    <i class="fa-solid fa-circle-check"></i> Selesai
                                                </span>
                                            @else
                                                <div class="flex items-center justify-center gap-2">
                                                    @if ($report->status === 'pending')
                                                        <form method="POST" action="{{ route('pegawai.maintenance.update', $report->id) }}" class="inline">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="status" value="on_progress">
                                                            <button type="submit" class="bg-blue-600 hover:bg-slate-900 text-white rounded-2xl font-black uppercase text-[10px] tracking-widest active:scale-95 px-4 py-2">
                                                                Proses
                                                            </button>
                                                        </form>
                                                    @endif
                                                    <form method="POST" action="{{ route('pegawai.maintenance.update', $report->id) }}" class="inline">
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
                </div>
            @endif
        @else
            <!-- Empty State -->
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 py-16 flex flex-col items-center justify-center">
                <i class="fa-solid fa-folder-open text-4xl text-slate-100 mb-3"></i>
                <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Tidak ada laporan ditemukan</span>
            </div>
        @endif
    </div>
</div>

<!-- Photo Modal -->
<div id="photoModal" class="fixed inset-0 bg-slate-900/80 hidden justify-center items-center z-[60] backdrop-blur-sm p-4" onclick="closePhotoModal()">
    <div class="relative max-w-4xl w-full flex justify-center animate-scale-up" onclick="event.stopPropagation()">
        <button onclick="closePhotoModal()" class="absolute -top-12 right-0 text-white text-3xl hover:text-gray-300 transition-all">&times;</button>
        <img id="modalImg" src="" class="rounded-3xl shadow-2xl max-h-[80vh] w-auto object-contain border border-white/10">
    </div>
</div>

<script>
    function openPhotoModal(src) {
        const modal = document.getElementById('photoModal');
        const img = document.getElementById('modalImg');
        img.src = src;
        modal.classList.replace('hidden', 'flex');
    }

    function closePhotoModal() {
        document.getElementById('photoModal').classList.replace('flex', 'hidden');
    }
</script>
@endsection
