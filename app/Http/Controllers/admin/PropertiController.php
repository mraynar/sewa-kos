<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Http\Request;

class PropertiController extends Controller
{
    public function index(Request $request)
    {
        $filterType = $request->input('filter_type');
        $filterGender = $request->input('filter_gender');

        $query = Room::with('roomType')->orderBy('room_type_id', 'asc');

        if (!empty($filterType)) {
            $query->where('room_type_id', $filterType);
        }

        if (!empty($filterGender)) {
            $query->where('gender_type', $filterGender);
        }

        $room = $query->paginate(6)->withQueryString();
        $roomTypes = RoomType::all();

        return view('admin.list-properti', compact('room', 'roomTypes', 'filterType', 'filterGender'));
    }

    public function create()
    {
        $roomTypes = RoomType::all();

        return view('admin.create-properti', compact('roomTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'room_type_id' => 'required|exists:room_types,id',
            'gender_type' => 'required|in:Putra,Putri',
            'price' => 'required|numeric|min:0',
            'facilities' => 'required|string|max:255',
            'area_size' => 'required|string|max:255',
            'is_electric_included' => 'required|in:0,1',
            'is_water_included' => 'required|in:0,1',
            'room_rules' => 'nullable|string',
        ], [
            'room_type_id.required' => 'Tipe kamar wajib dipilih.',
            'room_type_id.exists' => 'Tipe kamar tidak valid.',
            'gender_type.required' => 'Tipe gender wajib dipilih.',
            'gender_type.in' => 'Tipe gender tidak valid.',
            'price.required' => 'Harga wajib diisi.',
            'price.numeric' => 'Harga harus berupa angka.',
            'price.min' => 'Harga minimal 0.',
            'facilities.required' => 'Fasilitas wajib diisi.',
            'facilities.max' => 'Fasilitas maksimal 255 karakter.',
            'area_size.required' => 'Ukuran kamar wajib diisi.',
            'area_size.max' => 'Ukuran kamar maksimal 255 karakter.',
            'is_electric_included.required' => 'Status listrik wajib dipilih.',
            'is_electric_included.in' => 'Status listrik tidak valid.',
            'is_water_included.required' => 'Status air wajib dipilih.',
            'is_water_included.in' => 'Status air tidak valid.',
        ]);

        $roomType = RoomType::findOrFail($request->room_type_id);
        $inisial = strtoupper(substr($roomType->name, 0, 1));

        $lastRoom = Room::where('room_type_id', $request->room_type_id)
            ->orderBy('id', 'desc')
            ->first();

        if ($lastRoom) {
            $lastNumber = (int) preg_replace('/[^0-9]/', '', $lastRoom->room_number);
            $nextNumber = $lastNumber + 1;
        } else {
            $nextNumber = 1;
        }

        $roomNumber = $inisial . str_pad($nextNumber, 2, '0', STR_PAD_LEFT);

        Room::create([
            'room_type_id' => $request->room_type_id,
            'room_number' => $roomNumber,
            'gender_type' => $request->gender_type,
            'price' => $request->price,
            'facilities' => $request->facilities,
            'area_size' => $request->area_size,
            'is_electric_included' => $request->is_electric_included,
            'is_water_included' => $request->is_water_included,
            'room_rules' => $request->room_rules ?? '',
            'status' => 'available',
            'rating' => 0.0,
        ]);

        return redirect()->route('admin.properti.index')->with('success', 'Kamar ' . $roomNumber . ' berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $room = Room::findOrFail($id);
        $roomTypes = RoomType::all();

        return view('admin.edit-properti', compact('room', 'roomTypes'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:available,maintenance,occupied',
            'room_type_id' => 'required|exists:room_types,id',
            'gender_type' => 'required|in:Putra,Putri',
            'price' => 'required|numeric|min:0',
            'facilities' => 'required|string|max:255',
            'area_size' => 'required|string|max:255',
            'is_electric_included' => 'required|in:0,1',
            'is_water_included' => 'required|in:0,1',
            'room_rules' => 'nullable|string',
        ], [
            'status.required' => 'Status kamar wajib dipilih.',
            'status.in' => 'Status kamar tidak valid.',
            'room_type_id.required' => 'Tipe kamar wajib dipilih.',
            'room_type_id.exists' => 'Tipe kamar tidak valid.',
            'gender_type.required' => 'Tipe gender wajib dipilih.',
            'gender_type.in' => 'Tipe gender tidak valid.',
            'price.required' => 'Harga wajib diisi.',
            'price.numeric' => 'Harga harus berupa angka.',
            'price.min' => 'Harga minimal 0.',
            'facilities.required' => 'Fasilitas wajib diisi.',
            'facilities.max' => 'Fasilitas maksimal 255 karakter.',
            'area_size.required' => 'Ukuran kamar wajib diisi.',
            'area_size.max' => 'Ukuran kamar maksimal 255 karakter.',
            'is_electric_included.required' => 'Status listrik wajib dipilih.',
            'is_electric_included.in' => 'Status listrik tidak valid.',
            'is_water_included.required' => 'Status air wajib dipilih.',
            'is_water_included.in' => 'Status air tidak valid.',
        ]);

        $room = Room::findOrFail($id);

        $data = [
            'status' => $request->status,
            'room_type_id' => $request->room_type_id,
            'gender_type' => $request->gender_type,
            'price' => $request->price,
            'facilities' => $request->facilities,
            'area_size' => $request->area_size,
            'is_electric_included' => $request->is_electric_included,
            'is_water_included' => $request->is_water_included,
            'room_rules' => $request->room_rules ?? '',
        ];

        if ($room->room_type_id != $request->room_type_id) {
            $roomType = RoomType::findOrFail($request->room_type_id);
            $inisial = strtoupper(substr($roomType->name, 0, 1));

            $lastRoom = Room::where('room_type_id', $request->room_type_id)
                ->orderBy('id', 'desc')
                ->first();

            if ($lastRoom) {
                $lastNumber = (int) preg_replace('/[^0-9]/', '', $lastRoom->room_number);
                $nextNumber = $lastNumber + 1;
            } else {
                $nextNumber = 1;
            }

            $data['room_number'] = $inisial . str_pad($nextNumber, 2, '0', STR_PAD_LEFT);
        }

        $room->update($data);

        return redirect()->route('admin.properti.index')->with('success', 'Data kamar berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $room = Room::findOrFail($id);
        $room->delete();

        return redirect()->route('admin.properti.index')->with('success', 'Data kamar berhasil dihapus!');
    }
}
