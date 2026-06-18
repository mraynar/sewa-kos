<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;

class PesananController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $filterUser = $request->input('filter_user');
        $filterRoom = $request->input('filter_room');
        $filterStatus = $request->input('filter_status');

        $query = Booking::with(['user', 'room']);

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('id', 'LIKE', "%{$search}%")
                    ->orWhereHas('user', function ($q2) use ($search) {
                        $q2->where('full_name_ktp', 'LIKE', "%{$search}%");
                    });
            });
        }

        if (!empty($filterUser)) {
            $query->where('user_id', $filterUser);
        }

        if (!empty($filterRoom)) {
            $query->where('room_id', $filterRoom);
        }

        if (!empty($filterStatus)) {
            $query->where('status', $filterStatus);
        }

        $bookings = $query->latest()->paginate(7)->withQueryString();

        $users = User::whereHas('bookings')->orderBy('full_name_ktp')->get();
        $rooms = Room::orderBy('room_number')->get();

        return view('admin.list-pesanan', compact(
            'bookings',
            'search',
            'users',
            'rooms',
            'filterUser',
            'filterRoom',
            'filterStatus'
        ));
    }
}
