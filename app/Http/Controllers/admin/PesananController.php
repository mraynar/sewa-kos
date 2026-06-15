<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class PesananController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = Booking::with(['user', 'room']);

        if (! empty($search)) {
            $query->where('id', 'LIKE', "%{$search}%")
                ->orWhereHas('user', function ($q) use ($search) {
                    $q->where('full_name_ktp', 'LIKE', "%{$search}%");
                });
        }

        $bookings = $query->latest()->get();

        return view('admin.list-pesanan', compact('bookings', 'search'));
    }
}
