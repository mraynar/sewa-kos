@extends('pegawai.layouts.app')

@section('title', 'Tugas Layanan')
@section('tasks_active', 'active')
@section('page_title', 'Tugas Layanan')

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
            <h1 class="text-2xl font-bold text-gray-900">Daftar Tugas Layanan</h1>
            <p class="text-sm text-gray-500 mt-1">Daftar tugas layanan tambahan kamar kos yang didelegasikan untuk Anda.</p>
        </div>

        <form method="GET" action="{{ route('pegawai.tasks.index') }}" class="flex items-center gap-3 bg-white p-2 rounded-lg shadow border border-gray-200">
            <div class="flex items-center gap-2 px-2">
                <i class="fas fa-filter text-blue-500"></i>
                <select name="status" onchange="this.form.submit()" class="text-sm font-semibold text-gray-700 bg-transparent outline-none cursor-pointer">
                    <option value="" {{ request('status') === null || request('status') === '' ? 'selected' : '' }}>Semua Status</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Belum Dikerjakan</option>
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
                        <th class="px-6 py-3 text-xs font-semibold text-gray-600 uppercase">No</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-600 uppercase">Layanan</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-600 uppercase">Kamar</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-600 uppercase">Penyewa</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-600 uppercase text-center">Jumlah</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-600 uppercase text-center">Status</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-600 uppercase text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($tasks as $index => $task)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-sm text-gray-900 font-medium">{{ $index + 1 }}</td>
                            <td class="px-6 py-4">
                                <p class="text-sm font-bold text-gray-800">{{ $task->additionalService->name ?? 'Layanan' }}</p>
                                <p class="text-xs text-gray-500">Rp {{ number_format($task->price_at_purchase, 0, ',', '.') }}</p>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700 font-semibold">
                                {{ $task->booking->room->room_number ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700 font-medium uppercase">
                                {{ $task->booking->user->nickname ?? ($task->booking->user->name ?? 'Unknown') }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700 text-center font-semibold">
                                {{ $task->quantity }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                @php
                                    $badge_class = 'bg-amber-100 text-amber-800';
                                    $status_text = 'Belum Dikerjakan';
                                    
                                    if ($task->service_status === 'done') {
                                        $badge_class = 'bg-green-100 text-green-800';
                                        $status_text = 'Selesai';
                                    } elseif ($task->service_status === 'on_progress') {
                                        $badge_class = 'bg-blue-100 text-blue-800';
                                        $status_text = 'Sedang Dikerjakan';
                                    }
                                @endphp
                                <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase {{ $badge_class }}">
                                    {{ $status_text }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="text-xs text-gray-400 italic">No Action</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-16 text-center text-gray-500">
                                Tidak ada tugas yang ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
