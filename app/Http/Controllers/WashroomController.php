<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Washroom;

class WashroomController extends Controller
{
    public function index()
    {
        $washrooms = Washroom::all();
        return view('washrooms.index', compact('washrooms'));
    }

    public function create()
    {
        return view('washrooms.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'location' => 'required|string|max:255',
            'floor' => 'required|integer',
            'type' => 'required|in:Male,Female,Disabled',
            'status' => 'required|in:Clean,Dirty,Maintenance',
        ]);

        Washroom::create($validated);

        return redirect()->route('washrooms.index')->with('success', 'Washroom added successfully!');
    }

    public function edit(Washroom $washroom)
    {
        return view('washrooms.edit', compact('washroom'));
    }

    public function update(Request $request, Washroom $washroom)
    {
        $validated = $request->validate([
            'location' => 'required|string|max:255',
            'floor' => 'required|integer',
            'type' => 'required|in:Male,Female,Disabled',
            'status' => 'required|in:Clean,Dirty,Maintenance',
        ]);

        $washroom->update($validated);

        return redirect()->route('washrooms.index')->with('success', 'Washroom updated successfully!');
    }

    public function destroy(Washroom $washroom)
    {
        $washroom->delete();
        return redirect()->route('washrooms.index')->with('success', 'Washroom deleted successfully!');
    }
}

