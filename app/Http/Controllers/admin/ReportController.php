<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\MaintenanceRequest;
use App\Models\User;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $selected_month = $request->input('month', date('n'));
        $selected_year = $request->input('year', date('Y'));

        $employees = User::where('role', 'pegawai')->get(['id', 'nickname']);

        $reports = MaintenanceRequest::with(['user', 'employee'])
            ->whereMonth('created_at', $selected_month)
            ->whereYear('created_at', $selected_year)
            ->latest()
            ->get();

        return view('admin.user-report', compact('reports', 'employees', 'selected_month', 'selected_year'));
    }

    public function assign(Request $request)
    {
        $request->validate([
            'report_id' => 'required|exists:maintenance_requests,id',
            'worker_id' => 'required|exists:users,id',
        ]);

        $report = MaintenanceRequest::findOrFail($request->report_id);
        $report->update([
            'employee_id' => $request->worker_id,
            'status' => 'on_progress',
        ]);

        return redirect()->back()->with('success', 'Laporan berhasil diteruskan ke pegawai!');
    }
}
