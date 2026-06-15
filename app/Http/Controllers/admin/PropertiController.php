<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Http\Request;

class PropertiController extends Controller
{
    public function index()
    {
        $room = Room::with('roomType')
            ->orderBy('room_type_id', 'asc')
            ->get();

        return view('admin.list-properti', compact('room'));
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
            'is_electric_included' => 'required|boolean',
            'is_water_included' => 'required|boolean',
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
            'is_electric_included.boolean' => 'Status listrik tidak valid.',
            'is_water_included.required' => 'Status air wajib dipilih.',
            'is_water_included.boolean' => 'Status air tidak valid.',
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

        $roomNumber = $inisial.str_pad($nextNumber, 2, '0', STR_PAD_LEFT);

        $data = $request->all();
        $data['room_number'] = $roomNumber;
        $data['status'] = $request->status ?? 'available';
        $data['rating'] = $request->rating ?? 0.0;

        Room::create($data);

        return redirect()->route('admin.properti.index')->with('success', 'Kamar '.$roomNumber.' berhasil ditambahkan!');
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
            'is_electric_included' => 'required|boolean',
            'is_water_included' => 'required|boolean',
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
            'is_electric_included.boolean' => 'Status listrik tidak valid.',
            'is_water_included.required' => 'Status air wajib dipilih.',
            'is_water_included.boolean' => 'Status air tidak valid.',
        ]);

        $room = Room::findOrFail($id);
        $data = $request->all();

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

            $data['room_number'] = $inisial.str_pad($nextNumber, 2, '0', STR_PAD_LEFT);
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
