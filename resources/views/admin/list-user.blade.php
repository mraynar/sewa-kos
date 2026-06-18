@extends('admin.layouts.app')

@section('pengguna_active', 'active')
@section('content')
  <div class="">
    <div class="header-content flex flex-col md:flex-row justify-between mb-4 gap-3 items-start md:items-center">
      <div>
        <h1 class="text-xl md:text-2xl font-bold text-gray-800">Daftar Pengguna (Penyewa)</h1>

        @if (!empty($search))
          <p class="text-sm text-gray-600 mt-1">
            Hasil pencarian untuk: <b>{{ $search }}</b>
          </p>
        @endif
      </div>

      <form method="GET" action="{{ url('/admin/pengguna') }}" class="flex gap-2 w-full md:w-auto">
        <input type="text" name="search" placeholder="Cari Nama, Email, atau HP..." value="{{ $search }}"
          class="border px-4 py-2 rounded-lg w-full sm:w-64 focus:ring-2 focus:ring-blue-500 outline-none text-sm shadow-sm">
        <button type="submit"
          class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg font-semibold transition-all shadow-md min-h-[44px]">
          Cari
        </button>
      </form>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden border border-gray-100 text-left">
      <div class="overflow-x-auto">
        <table class="w-full border-collapse min-w-[700px]">
          <thead class="bg-blue-600 text-white">
            <tr>
              <th class="px-6 py-4 text-center text-sm font-semibold uppercase tracking-wider">No</th>
              <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider">Nama (KTP)</th>
              <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider">Email</th>
              <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider">Alamat</th>
              <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider">No Telp</th>
              <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider">Tgl Lahir</th>
              <th class="px-6 py-4 text-center text-sm font-semibold uppercase tracking-wider">Status</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-200">

            @forelse ($users as $index => $user)
              <tr class="hover:bg-gray-50 transition-colors">
                <td class="px-6 py-4 text-center text-sm text-gray-600">{{ $users->firstItem() + $index }}</td>
                <td class="px-6 py-4 text-sm font-bold text-gray-900">
                  {{ $user->full_name_ktp ?? 'Belum Verifikasi' }}
                </td>
                <td class="px-6 py-4 text-sm text-gray-600">{{ $user->email ?? '-' }}</td>
                <td class="px-6 py-4 text-sm text-gray-600 max-w-xs truncate">{{ $user->address ?? '-' }}</td>
                <td class="px-6 py-4 text-sm text-gray-600">{{ $user->phone ?? '-' }}</td>
                <td class="px-6 py-4 text-sm text-gray-600">
                  {{ !empty($user->birth_date) ? \Carbon\Carbon::parse($user->birth_date)->format('d/m/Y') : '-' }}
                </td>
                <td class="px-6 py-4 text-center">

                  @php
                    $status = $user->is_verified ?? 'unverified';
                    $bg = 'bg-red-100 text-red-700'; // Default merah untuk unverified/rejected

                    if ($status === 'verified') {
                        $bg = 'bg-green-100 text-green-700';
                    } elseif ($status === 'pending') {
                        $bg = 'bg-yellow-100 text-yellow-700';
                    }
                  @endphp

                  <span
                    class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest {{ $bg }}">
                    {{ $status }}
                  </span>
                </td>
              </tr>

            @empty
              <tr>
                <td colspan='7' class='py-20 text-center text-gray-400 font-medium italic'>Tidak ada data penyewa yang
                  ditemukan.</td>
              </tr>
            @endforelse

          </tbody>
        </table>
      </div>
      {{-- Pagination --}}
      @if ($users->hasPages())
        <div class="px-6 py-4 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-3">
          <p class="text-sm text-gray-500">
            Menampilkan {{ $users->firstItem() }}–{{ $users->lastItem() }} dari {{ $users->total() }} pengguna
          </p>
          <div>
            {{ $users->links('pagination::tailwind') }}
          </div>
        </div>
      @endif
    </div>
  </div>
@endsection
