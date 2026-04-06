<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Maintenance;
use App\Models\Washroom;

class MaintenanceController extends Controller
{
    public function index()
    {
        $maintenances = Maintenance::with('washroom')->latest()->get();
        $washrooms = Washroom::where('status', 'Maintenance')->orWhere('status', 'Dirty')->get();
        return view('maintenance.index', compact('maintenances', 'washrooms'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'washroom_id' => 'required|exists:washrooms,id',
            'issue' => 'required|string',
            'technician' => 'nullable|string',
        ]);

        Maintenance::create($validated);

        Washroom::find($request->washroom_id)->update(['status' => 'Maintenance']);

        return back()->with('success', 'Maintenance request logged successfully!');
    }

    public function updateStatus(Request $request, $id)
    {
        $maintenance = Maintenance::findOrFail($id);
        
        $maintenance->update([
            'status' => $request->status,
            'repair_date' => $request->status == 'Completed' ? now() : null
        ]);

        if ($request->status == 'Completed') {
            $maintenance->washroom->update(['status' => 'Clean', 'last_cleaned' => now()]);
        }

        return back()->with('success', 'Maintenance status updated!');
    }
}

