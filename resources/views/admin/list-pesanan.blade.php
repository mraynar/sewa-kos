@extends('admin.layouts.app')

@section('pesanan_active', 'active')
@section('content')
  <div class="header-content flex flex-col md:flex-row justify-between mb-4 gap-3">
    <div>
      <h1 class="text-xl md:text-2xl font-bold text-gray-800">Daftar Pesanan</h1>
      @if (!empty($search))
        <p class="text-sm text-gray-600 mt-1">
          Hasil pencarian untuk: <b>{{ $search }}</b>
        </p>
      @endif
    </div>

    <form method="GET" action="{{ url('/admin/pesanan') }}" class="flex gap-2">
      <input type="text" name="search" placeholder="Cari ID atau Nama..." value="{{ $search }}"
        class="border px-3 py-2 rounded-lg w-full sm:w-64 focus:ring-2 focus:ring-blue-500 outline-none text-sm shadow-sm">
      <button type="submit"
        class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg font-semibold transition-all shadow-md min-h-[44px]">
        Cari
      </button>
    </form>
  </div>

  {{-- Filter Bar --}}
  <form method="GET" action="{{ url('/admin/pesanan') }}"
    class="bg-white rounded-lg shadow p-4 mb-4 border border-gray-100">
    {{-- Pertahankan nilai search saat filter dipakai --}}
    @if (!empty($search))
      <input type="hidden" name="search" value="{{ $search }}">
    @endif

    <div class="flex flex-col sm:flex-row gap-3 items-end">
      {{-- Filter Pemesan --}}
      <div class="flex flex-col gap-1 flex-1">
        <label class="text-[10px] font-black uppercase tracking-widest text-gray-400">Pemesan</label>
        <select name="filter_user"
          class="border px-3 py-2 rounded-lg text-sm outline-none focus:ring-2 focus:ring-blue-500 bg-white">
          <option value="">Semua Pemesan</option>
          @foreach ($users as $user)
            <option value="{{ $user->id }}" {{ $filterUser == $user->id ? 'selected' : '' }}>
              {{ $user->full_name_ktp }}
            </option>
          @endforeach
        </select>
      </div>

      {{-- Filter Kamar --}}
      <div class="flex flex-col gap-1 flex-1">
        <label class="text-[10px] font-black uppercase tracking-widest text-gray-400">Kamar</label>
        <select name="filter_room"
          class="border px-3 py-2 rounded-lg text-sm outline-none focus:ring-2 focus:ring-blue-500 bg-white">
          <option value="">Semua Kamar</option>
          @foreach ($rooms as $room)
            <option value="{{ $room->id }}" {{ $filterRoom == $room->id ? 'selected' : '' }}>
              {{ $room->room_number }}
            </option>
          @endforeach
        </select>
      </div>

      {{-- Filter Status --}}
      <div class="flex flex-col gap-1 flex-1">
        <label class="text-[10px] font-black uppercase tracking-widest text-gray-400">Status</label>
        <select name="filter_status"
          class="border px-3 py-2 rounded-lg text-sm outline-none focus:ring-2 focus:ring-blue-500 bg-white">
          <option value="">Semua Status</option>
          <option value="pending" {{ $filterStatus == 'pending' ? 'selected' : '' }}>Pending</option>
          <option value="paid" {{ $filterStatus == 'paid' ? 'selected' : '' }}>Paid</option>
          <option value="cancelled" {{ $filterStatus == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
        </select>
      </div>

      <div class="flex gap-2">
        <button type="submit"
          class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg font-semibold transition-all shadow-md text-sm min-h-[42px]">
          Filter
        </button>
        <a href="{{ url('/admin/pesanan') }}"
          class="bg-gray-100 hover:bg-gray-200 text-gray-600 px-5 py-2 rounded-lg font-semibold transition-all text-sm min-h-[42px] flex items-center">
          Reset
        </a>
      </div>
    </div>
  </form>

  <div class="bg-white rounded-lg shadow overflow-hidden border border-gray-100 text-left">
    <div class="overflow-x-auto">
      <table class="w-full border-collapse min-w-[700px]">
        <thead class="bg-blue-600 text-white">
          <tr>
            <th class="px-6 py-4 text-center text-sm font-semibold uppercase tracking-wider">No</th>
            <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider">ID Pesanan</th>
            <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider">Pemesan</th>
            <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider">Room</th>
            <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider">Check In</th>
            <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider">Check Out</th>
            <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider">Total Harga</th>
            <th class="px-6 py-4 text-center text-sm font-semibold uppercase tracking-wider">Status</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">

          @forelse ($bookings as $index => $row)
            <tr class='hover:bg-gray-50 transition-colors'>
              {{-- Nomor urut tetap benar meski pakai pagination --}}
              <td class='px-6 py-4 text-center text-sm text-gray-600'>{{ $bookings->firstItem() + $index }}</td>
              <td class='px-6 py-4 text-sm font-bold text-gray-600'>{{ $row->id }}</td>
              <td class='px-6 py-4 text-sm text-gray-600'>{{ $row->user->full_name_ktp ?? 'User Terhapus' }}</td>
              <td class='px-6 py-4 text-sm font-bold text-gray-600'>{{ $row->room->room_number ?? '-' }}</td>
              <td class='px-6 py-4 text-sm text-gray-600'>{{ \Carbon\Carbon::parse($row->check_in)->format('d/m/Y') }}
              </td>
              <td class='px-6 py-4 text-sm text-gray-600'>{{ \Carbon\Carbon::parse($row->check_out)->format('d/m/Y') }}
              </td>
              <td class='px-6 py-4 text-sm text-gray-600'>Rp {{ number_format($row->total_price, 0, ',', '.') }}</td>
              <td class='px-6 py-4 text-center text-sm text-gray-600'>
                @php
                  $bg = 'bg-red-100 text-red-700';
                  if ($row->status === 'paid') {
                      $bg = 'bg-green-100 text-green-700';
                  }
                  if ($row->status === 'pending') {
                      $bg = 'bg-yellow-100 text-yellow-700';
                  }
                @endphp
                <span
                  class='px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest {{ $bg }}'>
                  {{ $row->status }}
                </span>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan='8' class='py-10 text-center text-gray-400 font-medium italic'>Tidak ada data pesanan</td>
            </tr>
          @endforelse

        </tbody>
      </table>
    </div>

    {{-- Pagination --}}
    @if ($bookings->hasPages())
      <div class="px-6 py-4 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-3">
        <p class="text-sm text-gray-500">
          Menampilkan {{ $bookings->firstItem() }}–{{ $bookings->lastItem() }} dari {{ $bookings->total() }} pesanan
        </p>
        <div>
          {{ $bookings->links('pagination::tailwind') }}
        </div>
      </div>
    @endif
  </div>

@endsection
