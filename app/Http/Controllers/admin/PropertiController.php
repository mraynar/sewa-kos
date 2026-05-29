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

        $data = $request->all();
        $data['room_number'] = $roomNumber;
        $data['status'] = $request->status ?? 'available';
        $data['rating'] = $request->rating ?? 0.0;

        Room::create($data);

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
