@extends('admin.layouts.app')

@section('task_active', 'active')
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
      <div>
        <h1 class="text-2xl font-bold text-gray-900">Penugasan Layanan</h1>
        <p class="text-sm text-gray-500 font-medium">Monitoring status pengerjaan harian staf operasional.</p>
      </div>

      <div class="flex flex-wrap items-center gap-3">
        <div class="flex gap-1 bg-white p-1 rounded-xl shadow-sm border border-gray-100">
          @php $categories = ['Semua', 'Catering', 'Laundry', 'Cleaning']; @endphp
          @foreach ($categories as $cat)
            <a href="{{ request()->fullUrlWithQuery(['category' => $cat]) }}"
              class="{{ $selected_category == $cat ? 'bg-blue-600 text-white' : 'text-gray-500 hover:bg-gray-50' }} px-4 py-2 rounded-lg text-[10px] font-black uppercase transition">
              {{ $cat }}
            </a>
          @endforeach
        </div>

        <form method="GET" action="{{ url()->current() }}"
          class="flex items-center gap-3 bg-white p-2 rounded-lg shadow border border-gray-200">
          <input type="hidden" name="category" value="{{ $selected_category }}">
          <div class="flex items-center gap-2 px-2 border-r border-gray-200">
            <i class="fas fa-calendar-alt text-blue-500 text-xs"></i>
            <select name="month" onchange="this.form.submit()"
              class="text-[11px] font-bold text-gray-700 bg-transparent outline-none cursor-pointer uppercase">
              @for ($m = 1; $m <= 12; $m++)
                <option value="{{ $m }}" {{ $selected_month == $m ? 'selected' : '' }}>
                  {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                </option>
              @endfor
            </select>
          </div>
          <input type="number" name="year" value="{{ $selected_year }}" onchange="this.form.submit()"
            class="w-16 text-[11px] font-bold text-gray-700 bg-transparent text-center outline-none font-bold">
        </form>
      </div>
    </div>

    <form method="POST" action="{{ route('admin.task.assign') }}">
      @csrf
      <div
        class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 mb-6 flex flex-col md:flex-row items-end gap-4">
        <div class="flex-1 text-left w-full">
          <label class="block text-[10px] font-black text-gray-400 uppercase mb-2 ml-1 tracking-widest">Tugaskan ke Staf
            (Filter: {{ $selected_category }})</label>
          <select name="employee_id"
            class="w-full bg-slate-50 border border-slate-200 rounded-xl px-5 py-3 text-sm font-bold outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition"
            required>
            <option value="" disabled selected>-- Pilih Pegawai Pelaksana --</option>
            @foreach ($employees as $emp)
              <option value="{{ $emp->id }}">{{ strtoupper($emp->nickname) }} ({{ $emp->name ?? '-' }})</option>
            @endforeach
          </select>
        </div>
        <button type="submit"
          class="w-full md:w-auto bg-blue-600 hover:bg-slate-900 text-white font-black uppercase text-[10px] tracking-widest px-8 py-4 rounded-xl shadow-lg shadow-blue-200 transition-all active:scale-95">
          Apply Assignment
        </button>
      </div>

      <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
          <table class="w-full text-left border-collapse">
            <thead class="bg-slate-50/50 border-b border-gray-100">
              <tr>
                <th class="px-6 py-4 text-center w-10">
                  <input type="checkbox" id="selectAll"
                    class="w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500 cursor-pointer">
                </th>
                <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">No.</th>
                <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Kamar & Tamu</th>

                <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Tanggal</th>

                <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Jenis Layanan</th>
                <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Staf Bertugas</th>
                <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Status
                  Hari Ini</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
              @forelse ($tasks as $task)
                <tr class="hover:bg-blue-50/30 transition-colors group">
                  <td class="px-6 py-4 text-center">
                    @if (!$task->employee_id)
                      <input type="checkbox" name="selected_services[]" value="{{ $task->id }}"
                        class="task-checkbox w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500 cursor-pointer">
                    @else
                      <i class="fas fa-lock text-gray-200 text-xs"></i>
                    @endif
                  </td>
                  <td class="px-6 py-4 text-[11px] font-bold text-slate-400">
                    {{ $loop->iteration }}
                  </td>
                  <td class="px-6 py-4">
                    <div class="flex flex-col text-left">
                      <span class="font-black text-slate-700 uppercase text-sm">Room
                        {{ $task->booking->room->room_number ?? '-' }}</span>
                      <span
                        class="text-[10px] font-bold text-gray-400 uppercase tracking-tight">{{ $task->booking->user->name ?? ($task->booking->user->full_name_ktp ?? 'User') }}</span>
                    </div>
                  </td>

                  <td class="px-6 py-4 text-left">
                    <span class="text-xs font-bold text-slate-600">
                      {{ \Carbon\Carbon::parse($task->created_at)->format('d M Y') }}
                    </span>
                  </td>

                  <td class="px-6 py-4 text-left">
                    <span
                      class="text-[10px] font-black text-blue-600 bg-blue-50 px-3 py-1.5 rounded-lg border border-blue-100 uppercase">
                      {{ $task->additionalService->service_name ?? 'Service Terhapus' }}
                    </span>
                  </td>
                  <td class="px-6 py-4 text-left">
                    @if ($task->employee_id)
                      <div class="flex items-center gap-2">
                        <div class="w-2 h-2 rounded-full bg-green-500"></div>
                        <span
                          class="text-xs font-black text-slate-700 uppercase">{{ $task->employee->nickname ?? 'Staf' }}</span>
                      </div>
                    @else
                      <span
                        class="text-[10px] font-bold text-gray-300 uppercase italic tracking-tighter text-left">Unassigned</span>
                    @endif
                  </td>
                  <td class="px-6 py-4 text-center">
                    @if ($task->employee_id)
                      <span
                        class="px-3 py-1 rounded-full text-[9px] font-black uppercase border bg-blue-100 text-blue-600 border-blue-200">
                        On Progress
                      </span>
                    @else
                      <span
                        class="px-3 py-1 rounded-full text-[9px] font-black uppercase border bg-amber-100 text-amber-600 border-amber-200">
                        Pending
                      </span>
                    @endif
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="7" class="px-6 py-20 text-center">
                    <i class="fas fa-filter text-4xl text-slate-100 mb-3 block"></i>
                    <p class="text-gray-400 text-[10px] font-black uppercase tracking-widest">Tidak ada layanan
                      {{ $selected_category }} pada periode ini</p>
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </form>
  </div>

  <script>
    const selectAll = document.getElementById('selectAll');
    const checkboxes = document.querySelectorAll('.task-checkbox');

    if (selectAll) {
      selectAll.addEventListener('change', function() {
        checkboxes.forEach(cb => cb.checked = this.checked);
      });
    }
  </script>
@endsection
