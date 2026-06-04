@extends('pegawai.layouts.app')

@section('title', 'Laporan Kerusakan')
@section('maintenance_active', 'active')
@section('page_title', 'Laporan Kerusakan')

@section('content')
<div class="container mx-auto">
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4 flex justify-between items-center" role="alert">
            <span class="block sm:inline font-medium">{{ session('success') }}</span>
            <button onclick="this.parentElement.style.display='none'" class="text-green-700 font-bold px-2 py-1 hover:text-green-900">&times;</button>
        </div>
    @endif

    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4 text-left">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Daftar Laporan Kerusakan</h1>
            <p class="text-sm text-gray-500 mt-1">Daftar komplain dan laporan kerusakan fasilitas kos yang ditugaskan kepada Anda.</p>
        </div>

        <form method="GET" action="{{ route('pegawai.maintenance.index') }}" class="flex items-center gap-3 bg-white p-2 rounded-lg shadow border border-gray-200">
            <div class="flex items-center gap-2 px-2">
                <i class="fas fa-filter text-blue-500"></i>
                <select name="status" onchange="this.form.submit()" class="text-sm font-semibold text-gray-700 bg-transparent outline-none cursor-pointer">
                    <option value="" {{ request('status') === null || request('status') === '' ? 'selected' : '' }}>Semua Status</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="on_progress" {{ request('status') === 'on_progress' ? 'selected' : '' }}>Sedang Dikerjakan</option>
                    <option value="done" {{ request('status') === 'done' ? 'selected' : '' }}>Selesai</option>
                </select>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-600 uppercase">Lokasi</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-600 uppercase">Pelapor</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-600 uppercase">Keluhan</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-600 uppercase text-center">Foto</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-600 uppercase text-center">Status</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-600 uppercase text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($reports as $report)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-left">
                                <span class="font-bold text-gray-900 block">{{ $report->location }}</span>
                                <span class="text-xs text-gray-500">Kamar: {{ $report->booking->room->room_number ?? 'N/A' }}</span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700 font-medium uppercase text-left">
                                {{ $report->user->nickname ?? ($report->user->name ?? 'Unknown') }}
                            </td>
                            <td class="px-6 py-4 text-left">
                                <p class="text-sm font-bold text-gray-800">{{ $report->issue_name }}</p>
                                <p class="text-xs text-gray-500 truncate max-w-[250px]">{{ $report->description }}</p>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if ($report->photo)
                                    <button onclick="openPhotoModal('{{ asset('assets/img/reports/' . $report->photo) }}')" class="text-blue-500 hover:text-blue-700 transition duration-200 active:scale-90">
                                        <i class="fas fa-image text-lg"></i>
                                    </button>
                                @else
                                    <span class="text-gray-300 italic text-xs">No Photo</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                @php
                                    $badge_class = 'bg-amber-100 text-amber-800';
                                    if ($report->status === 'done') {
                                        $badge_class = 'bg-green-100 text-green-800';
                                    } elseif ($report->status === 'on_progress') {
                                        $badge_class = 'bg-blue-100 text-blue-800';
                                    }
                                @endphp
                                <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase {{ $badge_class }}">
                                    {{ str_replace('_', ' ', $report->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if ($report->status === 'done')
                                    <span class="text-xs text-emerald-600 font-bold"><i class="fa-solid fa-circle-check mr-1"></i> Selesai</span>
                                @else
                                    <div class="flex items-center justify-center gap-2">
                                        @if ($report->status === 'pending')
                                            <form method="POST" action="{{ route('pegawai.maintenance.update', $report->id) }}" class="inline">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="on_progress">
                                                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white text-[10px] font-bold uppercase px-3 py-1.5 rounded-lg transition duration-200">
                                                    Proses
                                                </button>
                                            </form>
                                        @endif
                                        <form method="POST" action="{{ route('pegawai.maintenance.update', $report->id) }}" class="inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="done">
                                            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white text-[10px] font-bold uppercase px-3 py-1.5 rounded-lg transition duration-200">
                                                Selesai
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-16 text-center text-gray-500">
                                Laporan kerusakan tidak ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Photo Modal -->
<div id="photoModal" class="fixed inset-0 bg-black/80 hidden justify-center items-center z-[60] backdrop-blur-sm p-4" onclick="closePhotoModal()">
    <div class="relative max-w-4xl w-full flex justify-center" onclick="event.stopPropagation()">
        <button onclick="closePhotoModal()" class="absolute -top-12 right-0 text-white text-3xl hover:text-gray-300 transition-all">&times;</button>
        <img id="modalImg" src="" class="rounded-2xl shadow-2xl max-h-[80vh] w-auto object-contain border-4 border-white/10">
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
