<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\AdditionalService;
use Illuminate\Http\Request;

class AdditionalServiceController extends Controller
{
    public function index()
    {
        $services = AdditionalService::all();
        return view('admin.list-service', compact('services'));
    }

    public function create()
    {
        return view('admin.create-service');
    }

    public function store(Request $request)
    {
        $service = AdditionalService::create($request->all());
        return redirect()->route('admin.additional_services.index')->with('success', 'Layanan tambahan berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $service = AdditionalService::findOrFail($id);
        return view('admin.edit-service', compact('service'));
    }

    public function update(Request $request, $id)
    {
        $service = AdditionalService::findOrFail($id);

        $request->validate([
            'service_name' => 'required|string|max:255',
            'duration_type' => 'required|in:Harian,Mingguan,Bulanan',
            'service_price' => 'required|numeric|min:0',
        ]);

        $service->update($request->all());

        return redirect()->route('admin.additional_services.index')->with('success', 'Data layanan tambahan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $service = AdditionalService::findOrFail($id);
        $service->delete();

        return redirect()->route('admin.additional_services.index')->with('success', 'Data layanan tambahan berhasil dihapus!');
    }
}
