@extends('admin.layouts.app')
@section('additional_services_active', 'active')

@section('content')
  <div class="header-content flex items-center justify-between mb-4 align-middle">
    <h1 class="text-2xl font-bold text-gray-800">Additional Services</h1>
    <a href="{{ route('admin.additional_services.create') }}"
      class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">Tambah Service</a>
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

  <div class="bg-white rounded-lg shadow overflow-hidden border border-gray-100 text-left">
    <table class="w-full border-collapse">
      <thead class="bg-blue-600 text-white">
        <tr>
          <th class="px-6 py-4 text-center text-sm font-semibold uppercase tracking-wider">No</th>
          <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider">Service Name</th>
          <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider">Duration Type</th>
          <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider">Harga</th>
          <th class="px-6 py-4 text-center text-sm font-semibold uppercase tracking-wider">Aksi</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-200">

        @forelse ($services as $index => $item)
          <tr class='hover:bg-gray-50 transition-colors'>
            <td class='px-6 py-4 text-center text-sm text-gray-600'>{{ $index + 1 }}</td>
            <td class='px-6 py-4 text-sm text-gray-600'>{{ $item->service_name }}</td>
            <td class='px-6 py-4 text-sm text-gray-600'>{{ $item->duration_type }}</td>
            <td class='px-6 py-4 text-sm text-gray-600'>Rp{{ number_format($item->service_price, 0, ',', '.') }}</td>
            <td class='px-6 py-4 text-sm text-gray-600 flex gap-2 justify-center'>
              <a href="{{ route('admin.additional_services.edit', $item->id) }}"
                class='bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm w-16 text-center'>Edit</a>

              <button onclick="openModal({{ $item->id }})"
                class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm">Hapus</button>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan='5' class='py-20 text-center text-gray-400 font-medium italic'>Tidak ada data layanan yang
              ditemukan.</td>
          </tr>
        @endforelse

      </tbody>
    </table>
  </div>

  <div id="deleteModal" class="fixed inset-0 bg-black/60 hidden justify-center items-center z-50 backdrop-blur-sm">
    <div class="bg-white p-8 rounded-2xl w-full max-w-xs shadow-2xl border border-gray-100">
      <div class="text-center mb-6">
        <div class="w-16 h-16 bg-red-50 text-red-500 rounded-full flex items-center justify-center mx-auto mb-4">
          <i class="fas fa-trash-alt text-2xl"></i>
        </div>
        <h2 class="text-lg font-black text-slate-800 uppercase tracking-tighter">Hapus Layanan?</h2>
        <p class="text-xs text-gray-400 font-bold uppercase mt-1">Layanan ini akan dihapus secara permanen.</p>
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
      document.getElementById('formDelete').action = '/admin/additional-services/' + id;
      document.getElementById('deleteModal').classList.remove('hidden');
      document.getElementById('deleteModal').classList.add('flex');
    }

    function closeModal() {
      document.getElementById('deleteModal').classList.add('hidden');
      document.getElementById('deleteModal').classList.remove('flex');
    }
  </script>
@endsection
