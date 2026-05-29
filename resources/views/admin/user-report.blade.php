@extends('admin.layouts.app')

@section('report_active', 'active')
@section('content')
  <div class="container mx-auto">

    @if (session('success'))
      <div
        class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4 flex justify-between items-center"
        role="alert">
        <span class="block sm:inline font-medium">{{ session('success') }}</span>
        <button onclick="this.parentElement.style.display='none'"
          class="text-green-700 font-bold px-2 py-1 hover:text-green-900">&times;</button>
      </div>
    @endif

    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4 text-left">
      <h1 class="text-2xl font-bold text-gray-900">Laporan Keluhan User</h1>

      <form method="GET" action="{{ route('admin.report.index') }}"
        class="flex items-center gap-3 bg-white p-2 rounded-lg shadow border border-gray-200">
        <div class="flex items-center gap-2 px-2 border-r border-gray-200">
          <i class="fas fa-calendar-alt text-blue-500"></i>
          <select name="month" onchange="this.form.submit()"
            class="text-sm font-semibold text-gray-700 bg-transparent outline-none cursor-pointer">
            @for ($m = 1; $m <= 12; $m++)
              <option value="{{ $m }}" {{ $selected_month == $m ? 'selected' : '' }}>
                {{ date('F', mktime(0, 0, 0, $m, 1)) }}
              </option>
            @endfor
          </select>
        </div>
        <input type="number" name="year" value="{{ $selected_year }}" onchange="this.form.submit()"
          class="w-20 text-sm font-semibold text-gray-700 bg-transparent text-center outline-none">
      </form>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
      <div class="p-6 border-b border-gray-100 text-left">
        <h3 class="text-lg font-semibold text-gray-900">Daftar Laporan Masalah</h3>
      </div>
      <div class="overflow-x-auto">
        <table class="w-full text-left">
          <thead class="bg-gray-50 border-b border-gray-200">
            <tr>
              <th class="px-6 py-3 text-xs font-semibold text-gray-600 uppercase">Lokasi</th>
              <th class="px-6 py-3 text-xs font-semibold text-gray-600 uppercase">Pelapor</th>
              <th class="px-6 py-3 text-xs font-semibold text-gray-600 uppercase">Masalah</th>
              <th class="px-6 py-3 text-xs font-semibold text-gray-600 uppercase text-center">Foto</th>
              <th class="px-6 py-3 text-xs font-semibold text-gray-600 uppercase text-center">Status</th>
              <th class="px-6 py-3 text-xs font-semibold text-gray-600 uppercase text-center">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-200">
            @forelse ($reports as $report)
              <tr class="hover:bg-gray-50 transition">
                <td class="px-6 py-4 font-bold text-gray-900">{{ $report->location }}</td>

                <td class="px-6 py-4 text-sm text-gray-700 font-medium uppercase">
                  {{ $report->user->nickname ?? 'Unknown' }}</td>

                <td class="px-6 py-4">
                  <p class="text-sm font-bold text-gray-800">{{ $report->issue_name }}</p>
                  <p class="text-xs text-gray-500 truncate max-w-[200px]">{{ $report->description }}</p>
                </td>
                <td class="px-6 py-4 text-center">
                  @if ($report->photo)
                    <button onclick="openPhotoModal('{{ asset('assets/img/reports/' . $report->photo) }}')"
                      class="text-blue-500 hover:text-blue-700 transition-transform active:scale-90">
                      <i
                        class="fas {{ $report->status === 'done' ? 'fa-check-circle text-green-500' : 'fa-image' }} text-lg"></i>
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
                    }
                    if ($report->status === 'on_progress') {
                        $badge_class = 'bg-blue-100 text-blue-800';
                    }
                  @endphp
                  <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase {{ $badge_class }}">
                    {{ str_replace('_', ' ', $report->status) }}
                  </span>
                </td>
                <td class="px-6 py-4 text-center">
                  @if ($report->status === 'pending')
                    <button onclick="openAssignModal({{ $report->id }})"
                      class="bg-blue-600 hover:bg-blue-700 text-white text-[10px] font-bold uppercase px-4 py-2 rounded-lg transition-all shadow-md">
                      Assign
                    </button>
                  @else
                    <span class="text-gray-400 text-[10px] font-bold uppercase italic">Diteruskan</span>
                  @endif
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="6" class="px-6 py-16 text-center text-gray-500">
                  Tidak ada laporan user untuk periode ini.
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <div id="photoModal" class="fixed inset-0 bg-black/80 hidden justify-center items-center z-[60] backdrop-blur-sm p-4"
    onclick="closePhotoModal()">
    <div class="relative max-w-4xl w-full flex justify-center" onclick="event.stopPropagation()">
      <button onclick="closePhotoModal()"
        class="absolute -top-12 right-0 text-white text-3xl hover:text-gray-300 transition-all">&times;</button>
      <img id="modalImg" src=""
        class="rounded-2xl shadow-2xl max-h-[80vh] w-auto object-contain border-4 border-white/10">
    </div>
  </div>

  <div id="assignModal" class="fixed inset-0 bg-black/50 hidden justify-center items-center z-50 backdrop-blur-sm p-4">
    <div class="bg-white p-8 rounded-2xl w-full max-w-sm shadow-2xl">
      <h2 class="text-xl font-bold mb-4 text-gray-900 text-left">Teruskan Laporan</h2>

      <form method="POST" action="{{ route('admin.report.assign') }}">
        @csrf
        @method('PUT')

        <input type="hidden" name="report_id" id="report_id">

        <div class="mb-6 text-left">
          <label class="block text-sm font-semibold text-gray-700 mb-2">Pilih Pegawai Pelaksana</label>
          <select name="worker_id"
            class="w-full border border-gray-300 rounded-xl px-4 py-3 outline-none focus:ring-2 focus:ring-blue-500 text-sm"
            required>
            <option value="" disabled selected>-- Pilih Pegawai --</option>
            @foreach ($employees as $emp)
              <option value="{{ $emp->id }}">{{ $emp->nickname }}</option>
            @endforeach
          </select>
        </div>

        <div class="flex gap-3">
          <button type="button" onclick="closeAssignModal()"
            class="flex-1 px-4 py-3 bg-gray-100 rounded-xl font-bold text-gray-600 text-sm">Batal</button>
          <button type="submit"
            class="flex-1 px-4 py-3 bg-blue-600 text-white rounded-xl font-bold text-sm shadow-lg shadow-blue-200">Kirim
            Tugas</button>
        </div>
      </form>
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

    function openAssignModal(id) {
      document.getElementById('report_id').value = id;
      document.getElementById('assignModal').classList.replace('hidden', 'flex');
    }

    function closeAssignModal() {
      document.getElementById('assignModal').classList.replace('flex', 'hidden');
    }
  </script>
@endsection
