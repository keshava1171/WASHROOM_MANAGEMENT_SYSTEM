<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CleaningSchedule;
use App\Models\Washroom;

class CleaningController extends Controller
{
    public function index()
    {
        $schedules = CleaningSchedule::with('washroom')->latest()->get();
        $washrooms = Washroom::all();
        return view('cleaning.schedule', compact('schedules', 'washrooms'));
    }

    public function update(Request $request, $id)
    {
        $schedule = CleaningSchedule::findOrFail($id);
        $schedule->update(['status' => 'Completed']);
        

        $schedule->washroom->update([
            'status' => 'Clean',
            'last_cleaned' => now()
        ]);

        return back()->with('success', 'Cleaning task completed and status updated!');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'washroom_id' => 'required|exists:washrooms,id',
            'staff_name' => 'required|string',
            'cleaning_time' => 'required|date',
        ]);

        CleaningSchedule::create($validated);

        return back()->with('success', 'Cleaning scheduled successfully!');
    }
}

