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
                $query->where(function ($q) {
                    $q->whereNull('service_status')
                        ->orWhere('service_status', 'pending');
                });
            } else {
                $query->where('service_status', $status);
            }
        }

        // Category filter
        if ($request->has('category') && $request->category !== '') {
            $category = $request->category;
            $query->whereHas('additionalService', function ($q) use ($category) {
                $q->where('service_name', 'like', '%'.$category.'%');
            });
        }

        $tasks = $query->orderBy('created_at', 'desc')->get();

        $selectedStatus = $request->query('status', '');
        $selectedCategory = $request->query('category', '');

        return view('pegawai.tasks', compact('tasks', 'selectedStatus', 'selectedCategory'));
    }

    /**
     * Update the status of the assigned task.
     */
    public function updateStatus(Request $request, int $id): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'status' => 'required|in:on_progress,done',
        ]);

        $task = BookingService::where('id', $id)
            ->where('employee_id', Auth::id())
            ->firstOrFail();

        $task->update([
            'service_status' => $request->status,
        ]);

        return redirect()->back()->with('success', 'Status tugas berhasil diperbarui!');
    }
}
