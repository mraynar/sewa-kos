@extends('admin.layouts.app')

@section('pegawai_active', 'active')
@section('content')

  <div class="header-content flex flex-col md:flex-row items-start md:items-center justify-between mb-4 gap-3">
    <div>
      <h1 class="text-xl md:text-2xl font-bold text-gray-800">Daftar Akun Pegawai</h1>
      @if (!empty($search))
        <p class="text-sm text-gray-600 mt-1">Hasil pencarian untuk: <b>{{ $search }}</b></p>
      @endif
    </div>
    <div class="flex gap-2 w-full md:w-auto">
      <form method="GET" action="{{ route('admin.pegawai.index') }}" class="flex gap-2 flex-1 md:flex-none">
        <input type="text" name="search" placeholder="Cari Nama, Email, No HP" value="{{ $search }}"
          class="border px-3 py-2 rounded-lg w-full sm:w-64 focus:ring-2 focus:ring-blue-500 outline-none text-sm shadow-sm">
        <button type="submit"
          class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg font-semibold transition-all shadow-md min-h-[44px]">
          Cari
        </button>
      </form>
      <a href="{{ route('admin.pegawai.create') }}"
        class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded shadow-sm transition-all min-h-[44px] flex items-center whitespace-nowrap">
        Tambah Pegawai
      </a>
    </div>
  </div>

  @if (session('success'))
    <div
      class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4 flex justify-between items-center"
      role="alert">
      <span class="block sm:inline font-medium">{{ session('success') }}</span>
      <button onclick="this.parentElement.style.display='none'"
        class="text-green-700 font-bold px-2 py-1 hover:text-green-900">&times;</button>
    </div>
  @endif

  <div class="bg-white rounded-lg shadow overflow-hidden border border-gray-100 text-left">
    <div class="overflow-x-auto">
      <table class="w-full border-collapse min-w-[600px]">
        <thead class="bg-blue-600 text-white">
          <tr>
            <th class="px-6 py-4 text-center text-sm font-semibold uppercase tracking-wider">No</th>
            <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider">Nickname</th>
            <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider">Nama Lengkap</th>
            <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider">Email Login</th>
            <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider">WhatsApp</th>
            <th class="px-6 py-4 text-center text-sm font-semibold uppercase tracking-wider">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">

          @forelse ($pegawai as $index => $row)
            <tr class='hover:bg-gray-50 transition-colors'>
              <td class='px-6 py-4 text-center text-sm text-gray-600'>{{ $pegawai->firstItem() + $index }}</td>
              <td class='px-6 py-4 text-sm font-bold text-gray-900'>{{ $row->nickname }}</td>
              <td class='px-6 py-4 text-sm text-gray-600'>{{ $row->name ?? '-' }}</td>
              <td class='px-6 py-4 text-sm text-blue-600 font-bold'>{{ $row->email }}</td>
              <td class='px-6 py-4 text-sm text-gray-600'>{{ $row->phone ?? '-' }}</td>
              <td class='px-6 py-4 text-sm text-gray-600 flex gap-2 justify-center items-center'>
                <a href='{{ route('admin.pegawai.edit', $row->id) }}'
                  class='bg-blue-500 hover:bg-blue-600 text-white px-3 py-1.5 rounded text-xs font-bold w-16 text-center transition-all'>Edit</a>
                <button onclick="openModal({{ $row->id }})"
                  class="bg-red-500 hover:bg-red-600 text-white px-3 py-1.5 rounded text-xs font-bold transition-all">Hapus</button>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan='6' class='py-10 text-center text-gray-400 font-medium italic'>
                {{ !empty($search) ? 'Tidak ada pegawai yang cocok dengan pencarian.' : 'Belum ada data pegawai yang terdaftar.' }}
              </td>
            </tr>
          @endforelse

        </tbody>
      </table>
    </div>

    {{-- Pagination --}}
    @if ($pegawai->hasPages())
      <div class="px-6 py-4 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-3">
        <p class="text-sm text-gray-500">
          Menampilkan {{ $pegawai->firstItem() }}–{{ $pegawai->lastItem() }} dari {{ $pegawai->total() }} pegawai
        </p>
        <div>
          {{ $pegawai->links('pagination::tailwind') }}
        </div>
      </div>
    @endif

  </div>

  <div id="deleteModal" class="fixed inset-0 bg-black/60 hidden justify-center items-center z-50 backdrop-blur-sm">
    <div class="bg-white p-8 rounded-2xl w-full max-w-xs shadow-2xl border border-gray-100">
      <div class="text-center mb-6">
        <div class="w-16 h-16 bg-red-50 text-red-500 rounded-full flex items-center justify-center mx-auto mb-4">
          <i class="fas fa-trash-alt text-2xl"></i>
        </div>
        <h2 class="text-lg font-black text-slate-800 uppercase tracking-tighter">Hapus Akun?</h2>
        <p class="text-xs text-gray-400 font-bold uppercase mt-1">Pegawai ini tidak akan bisa login lagi.</p>
      </div>
      <form id="formDelete" method="POST" action="">
        @csrf
        @method('DELETE')
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
      let baseUrl = "{{ url('/admin/pegawai') }}";
      document.getElementById('formDelete').action = baseUrl + '/' + id;
      document.getElementById('deleteModal').classList.remove('hidden');
      document.getElementById('deleteModal').classList.add('flex');
    }

    function closeModal() {
      document.getElementById('deleteModal').classList.add('hidden');
      document.getElementById('deleteModal').classList.remove('flex');
    }
  </script>
@endsection
