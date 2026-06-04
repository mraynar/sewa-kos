<?php

namespace App\Http\Controllers\pegawai;

use App\Http\Controllers\Controller;
use App\Models\MaintenanceRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PegawaiMaintenanceController extends Controller
{
    /**
     * Display a listing of the assigned maintenance requests.
     */
    public function index(Request $request): View
    {
        $employeeId = Auth::id();

        $query = MaintenanceRequest::with(['user', 'booking.room'])
            ->where('employee_id', $employeeId);

        // Status filter
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        $reports = $query->orderBy('created_at', 'desc')->get();

        return view('pegawai.maintenance', compact('reports'));
    }

    /**
     * Update the status of the assigned maintenance request.
     */
    public function updateStatus(Request $request, int $id): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'status' => 'required|in:on_progress,done',
        ]);

        $report = MaintenanceRequest::where('id', $id)
            ->where('employee_id', Auth::id())
            ->firstOrFail();

        $report->update([
            'status' => $request->status,
        ]);

        return redirect()->back()->with('success', 'Status laporan kerusakan berhasil diperbarui!');
    }
}
