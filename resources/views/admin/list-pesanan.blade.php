@extends('admin.layouts.app')

@section('pesanan_active', 'active')
@section('content')
  <div class="header-content flex justify-between mb-4 align-middle">
    <div>
      <h1 class="text-2xl font-bold text-gray-800">Daftar Pesanan</h1>
      @if (!empty($search))
        <p class="text-sm text-gray-600 mt-1">
          Hasil pencarian untuk: <b>{{ $search }}</b>
        </p>
      @endif
    </div>

    <form method="GET" action="{{ url('/admin/pesanan') }}" class="mb-4 flex gap-2">
      <input type="text" name="search" placeholder="Cari ID atau Nama..." value="{{ $search }}"
        class="border px-3 py-2 rounded-lg w-64 focus:ring-2 focus:ring-blue-500 outline-none text-sm shadow-sm">
      <button type="submit"
        class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg font-semibold transition-all shadow-md">
        Cari
      </button>
    </form>
  </div>

  <div class="bg-white rounded-lg shadow overflow-hidden border border-gray-100 text-left">
    <table class="w-full border-collapse">
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
            <td class='px-6 py-4 text-center text-sm text-gray-600'>{{ $index + 1 }}</td>
            <td class='px-6 py-4 text-sm font-bold text-gray-600'>{{ $row->id }}</td>

            <td class='px-6 py-4 text-sm text-gray-600'>{{ $row->user->full_name_ktp ?? 'User Terhapus' }}</td>

            <td class='px-6 py-4 text-sm font-bold text-gray-600'>{{ $row->room->room_number ?? '-' }}</td>

            <td class='px-6 py-4 text-sm text-gray-600'>{{ \Carbon\Carbon::parse($row->check_in)->format('d/m/Y') }}</td>
            <td class='px-6 py-4 text-sm text-gray-600'>{{ \Carbon\Carbon::parse($row->check_out)->format('d/m/Y') }}
            </td>
            <td class='px-6 py-4 text-sm text-gray-600'>Rp {{ number_format($row->total_price, 0, ',', '.') }}</td>

            <td class='px-6 py-4 text-center text-sm text-gray-600'>
              @php
                $bg = 'bg-red-100 text-red-700'; // Default
                if ($row->status === 'paid') {
                    $bg = 'bg-green-100 text-green-700';
                }
                if ($row->status === 'pending') {
                    $bg = 'bg-yellow-100 text-yellow-700';
                }
              @endphp
              <span class='px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest {{ $bg }}'>
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

@endsection
