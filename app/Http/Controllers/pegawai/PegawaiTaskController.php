<?php

namespace App\Http\Controllers\pegawai;

use App\Http\Controllers\Controller;
use App\Models\BookingService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PegawaiTaskController extends Controller
{
    /**
     * Display a listing of the assigned tasks.
     */
    public function index(Request $request): View
    {
        $employeeId = Auth::id();

        $query = BookingService::with(['booking.room', 'booking.user', 'additionalService'])
            ->where('employee_id', $employeeId);

        // Status filter
        if ($request->has('status') && $request->status !== '') {
            $status = $request->status;
            if ($status === 'pending') {
                $query->whereNull('service_status');
            } else {
                $query->where('service_status', $status);
            }
        }

        $tasks = $query->orderBy('created_at', 'desc')->get();

        return view('pegawai.tasks', compact('tasks'));
    }
}
