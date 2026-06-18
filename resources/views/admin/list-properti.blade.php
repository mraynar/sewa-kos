@extends('admin.layouts.app')

@section('properti_active', 'active')
@section('content')
  <div class="header-content flex flex-wrap items-center justify-between mb-4 gap-3">
    <h1 class="text-xl md:text-2xl font-bold text-gray-800">Daftar Properti</h1>
    <a href="{{ route('admin.properti.create') }}"
      class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded min-h-[44px] flex items-center">Tambah
      Properti</a>
  </div>

  @if (session('success'))
    <div
      class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4 flex justify-between items-center"
      role="alert">
      <span class="block sm:inline font-medium">{{ session('success') }}</span>
      <button onclick="this.parentElement.style.display='none'"
        class="text-green-700 font-bold px-2 py-1 hover:text-green-900">
        &times;
      </button>
    </div>
  @endif

  {{-- Filter Bar --}}
  <form method="GET" action="{{ route('admin.properti.index') }}"
    class="bg-white rounded-lg shadow p-4 mb-4 border border-gray-100">
    <div class="flex flex-col sm:flex-row gap-3 items-end">

      {{-- Filter Tipe Kamar --}}
      <div class="flex flex-col gap-1 flex-1">
        <label class="text-[10px] font-black uppercase tracking-widest text-gray-400">Tipe Kamar</label>
        <select name="filter_type"
          class="border px-3 py-2 rounded-lg text-sm outline-none focus:ring-2 focus:ring-blue-500 bg-white">
          <option value="">Semua Tipe</option>
          @foreach ($roomTypes as $type)
            <option value="{{ $type->id }}" {{ $filterType == $type->id ? 'selected' : '' }}>
              {{ $type->name }}
            </option>
          @endforeach
        </select>
      </div>

      {{-- Filter Jenis Kelamin --}}
      <div class="flex flex-col gap-1 flex-1">
        <label class="text-[10px] font-black uppercase tracking-widest text-gray-400">Jenis Kelamin</label>
        <select name="filter_gender"
          class="border px-3 py-2 rounded-lg text-sm outline-none focus:ring-2 focus:ring-blue-500 bg-white">
          <option value="">Semua</option>
          <option value="Putra" {{ $filterGender == 'Putra' ? 'selected' : '' }}>Putra</option>
          <option value="Putri" {{ $filterGender == 'Putri' ? 'selected' : '' }}>Putri</option>
        </select>
      </div>

      <div class="flex gap-2">
        <button type="submit"
          class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg font-semibold transition-all shadow-md text-sm min-h-[42px]">
          Filter
        </button>
        <a href="{{ route('admin.properti.index') }}"
          class="bg-gray-100 hover:bg-gray-200 text-gray-600 px-5 py-2 rounded-lg font-semibold transition-all text-sm min-h-[42px] flex items-center">
          Reset
        </a>
      </div>
    </div>
  </form>

  <div class="bg-white rounded-lg shadow overflow-hidden border border-gray-100 text-left">
    <div class="overflow-x-auto">
      <table class="w-full border-collapse min-w-[640px]">
        <thead class="bg-blue-600 text-white">
          <tr>
            <th class="px-6 py-4 text-center text-sm font-semibold uppercase tracking-wider">No</th>
            <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider">Tipe Kamar</th>
            <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider">Nomor Kamar</th>
            <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider">Jenis Kelamin</th>
            <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider">Harga</th>
            <th class="px-6 py-4 text-center text-sm font-semibold uppercase tracking-wider">Status</th>
            <th class="px-6 py-4 text-center text-sm font-semibold uppercase tracking-wider">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
          @forelse ($room as $index => $item)
            <tr class='hover:bg-gray-50 transition-colors'>
              <td class='px-6 py-4 text-center text-sm text-gray-600'>{{ $room->firstItem() + $index }}</td>
              <td class='px-6 py-4 text-sm text-gray-600'>{{ $item->roomType->name ?? 'Tipe Dihapus' }}</td>
              <td class='px-6 py-4 text-sm text-gray-600'>{{ $item->room_number }}</td>
              <td class='px-6 py-4 text-sm text-gray-600'>{{ $item->gender_type }}</td>
              <td class='px-6 py-4 text-sm text-gray-600'>Rp{{ number_format($item->price, 0, ',', '.') }}</td>
              <td class='px-6 py-4 text-center text-sm text-gray-600'>
                <span
                  class='px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest
                  {{ $item->status === 'available' ? 'bg-green-100 text-green-700' : ($item->status === 'maintenance' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }}'>
                  {{ $item->status }}
                </span>
              </td>
              <td class='px-6 py-4 text-sm text-gray-600 flex gap-2 justify-center'>
                <a href='{{ url('admin/properti/' . $item->id . '/edit') }}'
                  class='bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm w-16 text-center'>Edit</a>
                <button onclick="openModal({{ $item->id }})"
                  class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm">Hapus</button>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan='7' class='py-20 text-center text-gray-400 font-medium italic'>Tidak ada data properti yang
                ditemukan.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    {{-- Pagination --}}
    @if ($room->hasPages())
      <div class="px-6 py-4 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-3">
        <p class="text-sm text-gray-500">
          Menampilkan {{ $room->firstItem() }}–{{ $room->lastItem() }} dari {{ $room->total() }} properti
        </p>
        <div>
          {{ $room->links('pagination::tailwind') }}
        </div>
      </div>
    @endif

  </div>

  {{-- Modal Hapus --}}
  <div id="deleteModal" class="fixed inset-0 bg-black/60 hidden justify-center items-center z-50 backdrop-blur-sm">
    <div class="bg-white p-8 rounded-2xl w-full max-w-xs shadow-2xl border border-gray-100">
      <div class="text-center mb-6">
        <div class="w-16 h-16 bg-red-50 text-red-500 rounded-full flex items-center justify-center mx-auto mb-4">
          <i class="fas fa-trash-alt text-2xl"></i>
        </div>
        <h2 class="text-lg font-black text-slate-800 uppercase tracking-tighter">Hapus Properti?</h2>
        <p class="text-xs text-gray-400 font-bold uppercase mt-1">Properti ini akan dihapus secara permanen.</p>
      </div>
      <form id="formDelete" method="POST" action="">
        @csrf
        @method('DELETE')
        <input type="hidden" name="delete_id" id="delete_id">
        <div class="flex gap-3">
          <button type="button" onclick="closeModal()"
            class="flex-1 py-3 bg-gray-100 text-gray-500 rounded-xl font-black uppercase text-[10px] tracking-widest hover:bg-gray-200 transition-colors">
            Batal
          </button>
          <button type="submit"
            class="flex-1 py-3 bg-red-600 hover:bg-red-700 text-white rounded-xl font-black uppercase text-[10px] tracking-widest shadow-lg shadow-red-200 transition-colors">
            Hapus
          </button>
        </div>
      </form>
    </div>
  </div>

  <script>
    function openModal(id) {
      document.getElementById('delete_id').value = id;
      document.getElementById('formDelete').action = '/admin/properti/' + id;
      document.getElementById('deleteModal').classList.remove('hidden');
      document.getElementById('deleteModal').classList.add('flex');
    }

    function closeModal() {
      document.getElementById('deleteModal').classList.add('hidden');
      document.getElementById('deleteModal').classList.remove('flex');
    }
  </script>
@endsection
