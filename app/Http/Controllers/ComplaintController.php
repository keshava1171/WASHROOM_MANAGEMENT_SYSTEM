<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Complaint;
use App\Models\Washroom;
use Illuminate\Support\Facades\Storage;

class ComplaintController extends Controller
{
    public function index()
    {
        $complaints = Complaint::with(['user', 'floor', 'room', 'washroom'])
                            ->where('user_id', auth()->id())
                            ->latest()
                            ->paginate(15);
        return view('complaints.index', compact('complaints'));
    }

    public function create()
    {

        $floors = \App\Models\Floor::with(['rooms.washrooms', 'washrooms' => function($q) {
            $q->whereNull('room_id');
        }])->orderBy('level')->get();
        return view('complaints.create', compact('floors'));
    }

    public function store(Request $request)
    {

        $data = $request->all();
        if (isset($data['room_id']) && (empty($data['room_id']) || $data['room_id'] == '')) $data['room_id'] = null;
        if (isset($data['washroom_id']) && (empty($data['washroom_id']) || $data['washroom_id'] == '')) $data['washroom_id'] = null;

        $request->merge($data);

        $validated = $request->validate([
            'floor_id'       => 'required',
            'room_id'        => 'nullable',
            'washroom_id'    => 'nullable',
            'complaint_type' => 'required|string',
            'description'    => 'required_if:complaint_type,Other|nullable|string|max:1000',
            'image'          => 'nullable|image|max:10240',
        ]);

        $f_id = !empty($validated['floor_id']) ? $validated['floor_id'] : null;
        $r_id = !empty($validated['room_id']) ? $validated['room_id'] : null;
        $w_id = !empty($validated['washroom_id']) ? $validated['washroom_id'] : null;

        if ($f_id && !\App\Models\Floor::find($f_id)) {
            return back()->withErrors(['selector' => 'The selected floor coordinates are invalid.'])->withInput();
        }
        if ($r_id && !\App\Models\Room::find($r_id)) {
            return back()->withErrors(['selector' => 'The selected room coordinate is invalid.'])->withInput();
        }
        if ($w_id && !\App\Models\Washroom::find($w_id)) {
            return back()->withErrors(['selector' => 'The selected unit is invalid.'])->withInput();
        }

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('complaints', 'public');
        }

        Complaint::create([
            'user_id'        => auth()->id(),
            'floor_id'       => $validated['floor_id'],
            'room_id'        => $validated['room_id'] ?? null,
            'washroom_id'    => $validated['washroom_id'] ?? null,
            'complaint_type' => $validated['complaint_type'],
            'description'    => $validated['description'] ?? null,
            'image_path'     => $imagePath,
            'status'         => 'pending',
        ]);

        return redirect()->route('dashboard')->with('success', 'Complaint submitted successfully! Protocol initiated.');
    }

    public function show(Complaint $complaint)
    {

        if (auth()->user()->role !== 'admin' && auth()->user()->role !== 'staff' && $complaint->user_id !== auth()->id()) {
            abort(403);
        }

        $complaint->load(['user', 'floor', 'room', 'washroom']);
        return view('complaints.show', compact('complaint'));
    }

    public function destroy(Complaint $complaint)
    {

        if (auth()->user()->role !== 'admin' && $complaint->user_id !== auth()->id()) {
            abort(403);
        }
        
        $complaint->delete();
        return back()->with('success', 'Complaint record expunged.');
    }

    public function print(Complaint $complaint)
    {
        $complaint->load(['user', 'floor', 'room', 'washroom']);
        return view('complaints.print', compact('complaint'));
    }
}

