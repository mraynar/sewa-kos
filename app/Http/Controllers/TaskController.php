<?php

namespace App\Http\Controllers;

use App\Models\BookingService;
use App\Models\User;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function task(Request $request)
    {
        $selected_month = $request->input('month', date('n'));
        $selected_year = $request->input('year', date('Y'));
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
            'selected_services' => 'required|array|min:1',
            'selected_services.*' => 'integer|exists:booking_service,id',
        ], [
            'employee_id.required' => 'Pegawai wajib dipilih.',
            'employee_id.exists' => 'Pegawai tidak ditemukan.',
            'selected_services.required' => 'Layanan wajib dipilih.',
            'selected_services.min' => 'Minimal satu layanan harus dipilih.',
            'selected_services.array' => 'Format layanan tidak valid.',
            'selected_services.*.integer' => 'ID layanan tidak valid.',
            'selected_services.*.exists' => 'Layanan tidak ditemukan di database.',
        ]);

        $affectedRows = BookingService::whereIn('id', $request->selected_services)
            ->whereNull('employee_id')
            ->update([
                'employee_id' => $request->employee_id,
                'service_status' => 'on_progress',
            ]);

        if ($affectedRows === 0) {
            return redirect()->back()->withErrors([
                'selected_services' => 'Tidak ada layanan yang berhasil ditugaskan. Layanan yang dipilih mungkin sudah dikerjakan staf lain.',
            ])->withInput();
        }

        return redirect()->back()->with('success', 'Berhasil menugaskan '.$affectedRows.' layanan!');
    }
}
