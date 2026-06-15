@extends('admin.layouts.app')

@section('properti_active', 'active')
@section('content')
  <div class="container mt-5">
    <div class="flex justify-between">
      <div class="backbtn">
        <a href="{{ URL::previous() }}">
          <div class="bg-blue-200 hover:bg-blue-300 transition-colors rounded-lg p-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
              <path fill="currentColor" d="M20 11v2H8l5.5 5.5l-1.42 1.42L4.16 12l7.92-7.92L13.5 5.5L8 11z" />
            </svg>
          </div>
        </a>
      </div>
      <div class="w-full max-w-2xl">
        <h2 class="text-3xl font-bold mb-6">Edit Data Kamar ({{ $room->room_number }})</h2>

        <form method="POST" action="{{ route('admin.properti.update', $room->id) }}"
          class="bg-white shadow-md rounded-lg p-6">
          @csrf
          @method('PUT')

          <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Status</label>
            <select
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
              name="status" required>
              <option disabled>-- Pilih --</option>
              <option value="available" {{ old('status', $room->status) == 'available' ? 'selected' : '' }}>Available</option>
              <option value="maintenance" {{ old('status', $room->status) == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
              <option value="occupied" {{ old('status', $room->status) == 'occupied' ? 'selected' : '' }}>Occupied</option>
            </select>
            @error('status')
              <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
          </div>

          <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Tipe Kamar</label>
            <select
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
              name="room_type_id" required>
              <option disabled>-- Pilih Tipe Kamar --</option>
              @foreach ($roomTypes as $type)
                <option value="{{ $type->id }}" {{ old('room_type_id', $room->room_type_id) == $type->id ? 'selected' : '' }}>
                  {{ $type->name }}</option>
              @endforeach
            </select>
            @error('room_type_id')
              <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
          </div>

          <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Tipe Gender</label>
            <select
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
              name="gender_type" required>
              <option disabled>-- Pilih Tipe Gender --</option>
              <option value="Putra" {{ old('gender_type', $room->gender_type) == 'Putra' ? 'selected' : '' }}>Putra</option>
              <option value="Putri" {{ old('gender_type', $room->gender_type) == 'Putri' ? 'selected' : '' }}>Putri</option>
            </select>
            @error('gender_type')
              <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
          </div>

          <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Harga</label>
            <input type="number" value="{{ old('price', $room->price) }}" placeholder="Contoh : 350000"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
              name="price" required>
            @error('price')
              <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
          </div>

          <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Fasilitas</label>
            <input type="text" value="{{ old('facilities', $room->facilities) }}" placeholder=" Contoh : Bed, Lemari, Meja Belajar"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
              name="facilities" required>
            @error('facilities')
              <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
          </div>

          <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Ukuran Kamar (m)</label>
            <input type="text" value="{{ old('area_size', $room->area_size) }}" placeholder=" Contoh : 4x6"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
              name="area_size" required>
            @error('area_size')
              <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
          </div>

          <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Listrik</label>
            <select
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
              name="is_electric_included" required>
              <option disabled>-- Pilih --</option>
              <option value="0" {{ old('is_electric_included', $room->is_electric_included) == 0 ? 'selected' : '' }}>Token</option>
              <option value="1" {{ old('is_electric_included', $room->is_electric_included) == 1 ? 'selected' : '' }}>Include</option>
            </select>
            @error('is_electric_included')
              <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
          </div>

          <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Air</label>
            <select
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
              name="is_water_included" required>
              <option disabled>-- Pilih --</option>
              <option value="0" {{ old('is_water_included', $room->is_water_included) == 0 ? 'selected' : '' }}>Tidak Ada</option>
              <option value="1" {{ old('is_water_included', $room->is_water_included) == 1 ? 'selected' : '' }}>Include</option>
            </select>
            @error('is_water_included')
              <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
          </div>

          <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Peraturan Kamar</label>
            <textarea class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
              name="room_rules" rows="4">{{ old('room_rules', $room->room_rules) }}</textarea>
            @error('room_rules')
              <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
          </div>

          <button type="submit"
            class="w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg transition duration-200">
            Simpan Perubahan
          </button>
        </form>
      </div>
      <div></div>
    </div>
  </div>
@endsection
