<?php

namespace App\Http\Controllers\pegawai;

use App\Http\Controllers\Controller;
use App\Models\BookingService;
use App\Models\MaintenanceRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class PegawaiDashboardController extends Controller
{
    /**
     * Display the pegawai dashboard with stats.
     */
    public function index(): View
    {
        $employeeId = Auth::id();

        // Stats for Booking Service (Tugas Layanan)
        $totalTasks = BookingService::where('employee_id', $employeeId)->count();
        $pendingTasks = BookingService::where('employee_id', $employeeId)
            ->where(function ($query) {
                $query->whereNull('service_status')
                    ->orWhere('service_status', 'on_progress');
            })->count();
        $completedTasks = BookingService::where('employee_id', $employeeId)
            ->where('service_status', 'done')
            ->count();

        // Stats for Maintenance Requests (Laporan Kerusakan)
        $totalMaintenance = MaintenanceRequest::where('employee_id', $employeeId)->count();
        $pendingMaintenance = MaintenanceRequest::where('employee_id', $employeeId)
            ->where(function ($query) {
                $query->where('status', 'pending')
                    ->orWhere('status', 'on_progress');
            })->count();
        $completedMaintenance = MaintenanceRequest::where('employee_id', $employeeId)
            ->where('status', 'done')
            ->count();

        // Reusable count stats for 3-col display
        $activeTasksCount = $pendingTasks;
        $activeMaintenanceCount = $pendingMaintenance;
        $completedCount = $completedTasks + $completedMaintenance;

        // Upcoming Tasks list
        $upcomingTasks = BookingService::with(['booking.room', 'booking.user', 'additionalService'])
            ->where('employee_id', $employeeId)
            ->where(function ($query) {
                $query->whereNull('service_status')
                    ->orWhere('service_status', 'on_progress');
            })
            ->orderBy('created_at', 'asc')
            ->paginate(5);

        return view('pegawai.dashboard', compact(
            'totalTasks',
            'pendingTasks',
            'completedTasks',
            'totalMaintenance',
            'pendingMaintenance',
            'completedMaintenance',
            'activeTasksCount',
            'activeMaintenanceCount',
            'completedCount',
            'upcomingTasks'
        ));
    }
}
