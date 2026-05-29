<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Room;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $properti = Room::all();
        $user = User::all();
        $booking = Booking::all();

        $total_pendapatan = Booking::where('status', 'paid')->sum('total_price');

        $filter_type = $request->get('filter_type', 'month');
        $now = Carbon::now();
        $chart_data = [];
        $chart_categories = [];

        $query = Booking::where('status', 'paid');

        if ($filter_type == 'week') {
            $start = $now->copy()->subDays(6)->startOfDay();
            $bookings = $query->where('created_at', '>=', $start)->get();

            for ($i = 0; $i < 7; $i++) {
                $date = $start->copy()->addDays($i);
                $chart_categories[] = $date->translatedFormat('d M');
                $chart_data[] = $bookings->filter(function ($b) use ($date) {
                    return Carbon::parse($b->created_at)->format('Y-m-d') == $date->format('Y-m-d');
                })->sum('total_price');
            }
        } elseif ($filter_type == 'month') {
            $daysInMonth = $now->daysInMonth;
            $bookings = $query->whereMonth('created_at', $now->month)
                ->whereYear('created_at', $now->year)->get();

            for ($i = 1; $i <= $daysInMonth; $i++) {
                $chart_categories[] = $i;
                $chart_data[] = $bookings->filter(function ($b) use ($i) {
                    return Carbon::parse($b->created_at)->day == $i;
                })->sum('total_price');
            }
        } elseif ($filter_type == 'year') {
            $bookings = $query->whereYear('created_at', $now->year)->get();

            for ($i = 1; $i <= 12; $i++) {
                $date = Carbon::create()->month($i);
                $chart_categories[] = $date->translatedFormat('M');
                $chart_data[] = $bookings->filter(function ($b) use ($i) {
                    return Carbon::parse($b->created_at)->month == $i;
                })->sum('total_price');
            }
        }

        $roomStats = DB::table('rooms')
            ->join('room_types', 'rooms.room_type_id', '=', 'room_types.id')
            ->select(
                'room_types.name as type_name',
                DB::raw('COUNT(rooms.id) as total_rooms'),
                DB::raw('SUM(CASE WHEN rooms.status = "available" THEN 1 ELSE 0 END) as available_rooms')
            )
            ->groupBy('room_types.id', 'room_types.name')
            ->get();

        $pie_labels = $roomStats->pluck('type_name')->toArray();
        $pie_series = $roomStats->pluck('total_rooms')->map(fn($val) => (int)$val)->toArray();
        $pie_sisa = $roomStats->pluck('available_rooms')->map(fn($val) => (int)$val)->toArray();

        return view('admin.index', compact(
            'properti',
            'user',
            'booking',
            'total_pendapatan',
            'filter_type',
            'chart_data',
            'chart_categories',
            'pie_labels',
            'pie_series',
            'pie_sisa'
        ));
    }
}
