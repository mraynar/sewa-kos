@extends('admin.layouts.app')

@section('additional_services_active', 'active')

@section('content')
  <div class="container mt-5">
    <div class="flex justify-between">
      <div class="backbtn">
        <a href="{{ URL::previous() }}">
          <div class="bg-blue-200 rounded-lg p-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
              <path fill="currentColor" d="M20 11v2H8l5.5 5.5l-1.42 1.42L4.16 12l7.92-7.92L13.5 5.5L8 11z" />
            </svg>
          </div>
        </a>
      </div>
      <div class="w-full max-w-2xl">
        <h2 class="text-3xl font-bold mb-6">Buat Service Baru</h2>
        <form method="POST" action="{{ route('admin.additional_services.store') }}"
          class="bg-white shadow-md rounded-lg p-6">
          @csrf
          <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Nama Service</label>
            <input type="text" placeholder="Contoh : Laundry Express" value="{{ old('service_name') }}"
              class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 {{ $errors->has('service_name') ? 'border-red-400' : 'border-gray-300' }}"
              name="service_name" required>
            @error('service_name')
              <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
          </div>

          <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Duration Type</label>
            <select
              class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 {{ $errors->has('duration_type') ? 'border-red-400' : 'border-gray-300' }}"
              name="duration_type" required>
              <option selected disabled>-- Pilih --</option>
              <option value="Harian" {{ old('duration_type') == 'Harian' ? 'selected' : '' }}>Harian</option>
              <option value="Mingguan" {{ old('duration_type') == 'Mingguan' ? 'selected' : '' }}>Mingguan</option>
              <option value="Bulanan" {{ old('duration_type') == 'Bulanan' ? 'selected' : '' }}>Bulanan</option>
            </select>
            @error('duration_type')
              <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
          </div>

          <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Harga Service</label>
            <input type="number" placeholder="Contoh : 50000" value="{{ old('service_price') }}"
              class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 {{ $errors->has('service_price') ? 'border-red-400' : 'border-gray-300' }}"
              name="service_price" required>
            @error('service_price')
              <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
          </div>
          <button type="submit"
            class="w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg transition duration-200">Simpan
            Service</button>
        </form>
      </div>
      <div></div>
    </div>
  </div>
@endsection
