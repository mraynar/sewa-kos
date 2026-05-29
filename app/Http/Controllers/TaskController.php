<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\BookingService;
use App\Models\User;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function task(Request $request)
    {
        $selected_month = $request->input('month', date('n'));
        $selected_year  = $request->input('year', date('Y'));
        $selected_category = $request->input('category', 'Semua');

        $employees = User::where('role', 'pegawai')->get(['id', 'nickname', 'name']);

        // HAPUS ->withCount() DARI SINI
        $query = BookingService::with(['booking.room', 'booking.user', 'additionalService', 'employee'])
            ->whereMonth('created_at', $selected_month)
            ->whereYear('created_at', $selected_year);

        if ($selected_category !== 'Semua') {
            $query->whereHas('additionalService', function ($q) use ($selected_category) {
                $q->where('service_name', 'LIKE', "%{$selected_category}%");
            });
        }

        $tasks = $query->orderByRaw('employee_id IS NULL DESC')
            ->orderBy('created_at', 'DESC')
            ->get();

        return view('admin.assign-task', compact('tasks', 'employees', 'selected_month', 'selected_year', 'selected_category'));
    }

    public function assignTask(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:users,id',
            'selected_services' => 'required|array',
        ]);

        BookingService::whereIn('id', $request->selected_services)
            ->update([
                'employee_id' => $request->employee_id,
                'service_status' => 'on_progress'
            ]);

        return redirect()->back()->with('success', 'Berhasil menugaskan ' . count($request->selected_services) . ' layanan!');
    }
}
