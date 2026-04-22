<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Floor;
use App\Models\Room;
use App\Models\Washroom;
use App\Models\User;
use App\Models\Task;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\StaffWelcomeEmail;

class AdminController extends Controller
{
    public function dashboard()
    {

        $floors = Floor::with([
            'rooms' => function ($query) {
                $query->orderBy('room_number', 'asc'); },
            'washrooms' => function ($query) {
                $query->orderBy('room_number', 'asc'); }
        ])->orderBy('level', 'asc')->get();

        $activeTasks = Task::where('status', 'assigned')->get();
        $completedTasks = Task::where('status', 'completed')->latest()->get();

        $floors->each(function ($floor) use ($activeTasks, $completedTasks) {
            foreach ($floor->rooms as $room) {
                if ($activeTasks->where('room_id', $room->id)->isNotEmpty()) {
                    $room->status = 'assigned';
                } elseif ($completedTasks->where('room_id', $room->id)->isNotEmpty()) {
                    $room->status = 'completed';
                } else {
                    $room->status = 'default';
                }
            }
            foreach ($floor->washrooms as $washroom) {
                if ($activeTasks->where('washroom_id', $washroom->id)->isNotEmpty()) {
                    $washroom->status = 'assigned';
                } elseif ($completedTasks->where('washroom_id', $washroom->id)->isNotEmpty()) {
                    $washroom->status = 'completed';
                } else {
                    $washroom->status = 'default';
                }
            }
        });

        $staff = User::staff()->get();

        $stats = [
            'total_tasks' => Task::count(),
            'completed_tasks' => Task::where('status', 'completed')->count(),
            'pending_tasks' => Task::where('status', 'assigned')->count(),
            'total_complaints' => \App\Models\Complaint::count(),
            'pending_complaints' => \App\Models\Complaint::where('status', 'pending')->count(),
        ];

        return view('admin.dashboard', compact('floors', 'staff', 'stats'));
    }

    public function structure()
    {
        $floors = Floor::with(['rooms', 'washrooms'])->orderBy('level')->get();

        $nextIndices = [];
        foreach ($floors as $floor) {
            $levelValue = (int) $floor->level;
            $roomPrefix = ($levelValue === 0) ? 'G' : (string) $levelValue;
            $pwPrefix = ($levelValue === 0) ? 'GPW' : 'PW' . $levelValue;


            $roomIndices = Room::where('floor_id', $floor->id)
                ->pluck('room_number')
                ->filter(fn($n) => str_starts_with($n, $roomPrefix))
                ->map(fn($n) => (int) substr($n, strlen($roomPrefix)))
                ->toArray();
            $nextRoom = $roomIndices ? (max($roomIndices) + 1) : 1;


            $pwIndices = Washroom::where('floor_id', $floor->id)
                ->whereNull('room_id')
                ->pluck('room_number')
                ->filter(fn($n) => str_starts_with($n, $pwPrefix))
                ->map(fn($n) => (int) substr($n, strlen($pwPrefix)))
                ->toArray();
            $nextPw = $pwIndices ? (max($pwIndices) + 1) : 1;

            $nextIndices[$floor->id] = ['room' => $nextRoom, 'washroom' => $nextPw];
        }

        return view('admin.structure', compact('floors', 'nextIndices'));
    }

    public function storeStructure(Request $request)
    {
        $validated = $request->validate([
            'floor_name' => 'required|string|max:255',
            'room_number' => 'nullable|string|max:50',
            'room_type' => 'required|in:private,general',
            'washroom_name' => 'required|string|max:255',
            'washroom_type' => 'required|in:attached,public',
        ]);

        $floor = Floor::firstOrCreate(['name' => $validated['floor_name']]);

        $room = null;
        if ($validated['washroom_type'] === 'attached') {

            if (empty($validated['room_number'])) {
                return back()->withErrors(['room_number' => 'Room number is required for attached washrooms']);
            }

            $room = Room::firstOrCreate([
                'floor_id' => $floor->id,
                'room_number' => $validated['room_number'],
            ], [
                'room_name' => $validated['room_number'],
                'type' => $validated['room_type'],
            ]);
        }

        $roomNumber = $validated['washroom_name'];
        if ($validated['washroom_type'] === 'public') {
            if (empty($roomNumber)) {
                $prefix = ($floor->level == 0) ? 'G' : (string) $floor->level;
                $count = Washroom::where('floor_id', $floor->id)->where('type', 'public')->count() + 1;
                $roomNumber = $prefix . '-W' . str_pad($count, 2, '0', STR_PAD_LEFT);


                while (Washroom::where('floor_id', $floor->id)->where('room_number', $roomNumber)->exists()) {
                    $count++;
                    $roomNumber = $prefix . '-W' . str_pad($count, 2, '0', STR_PAD_LEFT);
                }
            }
        }

        Washroom::create([
            'floor_id' => $floor->id,
            'room_id' => $room?->id,
            'room_number' => $roomNumber,
            'name' => $validated['washroom_name'] ?? $roomNumber,
            'type' => $validated['washroom_type'],
        ]);

        return back()->with('success', 'Structure added successfully!');
    }

    public function tasks()
    {
        $tasks = Task::with(['assignee', 'washroom', 'room', 'floor'])->latest()->paginate(10)->withQueryString();
        $staff = User::staff()->get();

        $stats = [
            'pending' => Task::where('status', 'pending')->count(),
            'in_progress' => Task::where('status', 'in_progress')->count(),
            'completed' => Task::where('status', 'completed')->count(),
            'total' => Task::count(),
        ];

        return view('admin.tasks', compact('tasks', 'staff', 'stats'));
    }

    public function assignTasks(Request $request)
    {
        $validated = $request->validate([
            'washrooms' => 'required|array',
            'washrooms.*' => 'exists:washrooms,id',
            'assigned_to' => 'required|exists:users,id',
        ]);

        foreach ($validated['washrooms'] as $washroomId) {
            $washroom = Washroom::find($washroomId);
            if ($washroom) {
                Task::firstOrCreate(
                    [
                        'floor_id' => $washroom->floor_id,
                        'washroom_id' => $washroom->id,
                        'assigned_to' => $validated['assigned_to'],
                        'status' => 'pending',
                    ],
                    ['room_id' => $washroom->room_id]
                );
            }
        }

        if ($request->ajax()) {
            return response()->json(['message' => 'Tactical tasks dispatched and operational units assigned.']);
        }

        return back()->with('success', 'Tasks assigned successfully!');
    }

    public function assignBulkTasks(Request $request)
    {
        $request->validate([
            'selections' => 'required|array',
            'selections.*.id' => 'required',
            'selections.*.floor_id' => 'required',
            'selections.*.type' => 'required|in:room,public',
            'assigned_to' => 'required|exists:users,id',
        ]);

        foreach ($request->selections as $selection) {
            if ($selection['type'] === 'public') {
                // Standalone washroom (not attached to a room)
                $washroom = Washroom::find($selection['id']);
                if ($washroom) {
                    Task::firstOrCreate([
                        'floor_id' => $selection['floor_id'],
                        'room_id' => null,
                        'washroom_id' => $washroom->id,
                        'assigned_to' => $request->assigned_to,
                    ], ['status' => 'assigned']);
                }
            } else {
                // Room node — create ONE task for the room, no washroom loop
                $room = Room::find($selection['id']);
                if ($room) {
                    Task::firstOrCreate([
                        'floor_id' => $selection['floor_id'],
                        'room_id' => $room->id,
                        'washroom_id' => null,
                        'assigned_to' => $request->assigned_to,
                    ], ['status' => 'assigned']);
                }
            }
        }

        return response()->json(['success' => true]);
    }

    public function users(Request $request)
    {
        $query = User::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%");
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->whereNotNull('email_verified_at');
            } elseif ($request->status === 'pending') {
                $query->whereNull('email_verified_at');
            }
        }

        $users = $query->latest()->paginate(10)->withQueryString();

        return view('admin.users', compact('users'));
    }

    public function createUser(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|in:admin,staff,user',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'must_change_password' => $validated['role'] === 'staff',
        ]);

        return back()->with('success', 'User created successfully!');
    }

    public function showTasks()
    {
        $tasks = Task::with(['assignee', 'washroom', 'room', 'floor'])->latest()->paginate(10)->withQueryString();
        $staff = User::where('role', 'staff')->get();
        return view('admin.tasks', compact('tasks', 'staff'));
    }

    public function usersRegistry()
    {
        $users = User::paginate(10)->withQueryString();
        return view('admin.registries.users', compact('users'));
    }

    public function operationLogs()
    {
        $tasks = Task::with(['floor', 'room', 'washroom', 'assignee'])->latest()->paginate(10)->withQueryString();
        return view('admin.registries.logs', compact('tasks'));
    }

    public function assetDatabase()
    {
        $floors = Floor::with(['rooms', 'washrooms'])->get();
        $rooms = Room::with('floor')->get();
        $washrooms = Washroom::with(['floor', 'room'])->get();
        return view('admin.registries.assets', compact('floors', 'rooms', 'washrooms'));
    }

    public function showLogs()
    {
        $tasks = Task::with(['floor', 'room', 'washroom', 'assignee'])->latest()->paginate(10)->withQueryString();
        return view('admin.registries.logs', compact('tasks'));
    }

    public function showAssets()
    {
        $floors = Floor::all();
        $rooms = Room::with('floor')->get();
        $washrooms = Washroom::with(['floor', 'room'])->get();
        return view('admin.registries.assets', compact('floors', 'rooms', 'washrooms'));
    }

    public function debugDB()
    {
        $users = User::all();
        $tasks = Task::with(['assignee', 'washroom'])->get();
        return view('admin.debug', compact('users', 'tasks'));
    }

    public function showCreateStaff()
    {
        return view('admin.create-staff');
    }

    public function storeStaff(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
        ]);

        $tempPassword = Str::random(10);

        $staff = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($tempPassword),
            'role' => 'staff',
            'must_change_password' => true,
        ]);

        $mailSent = false;
        try {
            Mail::to($staff->email)->send(new StaffWelcomeEmail($staff->name, $staff->email, $tempPassword, auth()->user()));
            $mailSent = true;
        } catch (\Exception $e) {
            \Log::warning("Staff welcome email failed for {$staff->email}: " . $e->getMessage());
        }

        if ($mailSent) {
            return back()->with('success', "Staff account for '{$staff->name}' created and credentials dispatched to their uplink (" . $staff->email . "). Check the system logs for verification.");
        }

        return back()->with([
            'success' => "Staff account for '{$staff->name}' created successfully.",
            'staff_creds' => [
                'name' => $staff->name,
                'email' => $staff->email,
                'password' => $tempPassword,
            ],
            'mail_warning' => 'Email could not be routed (Log Driver Active). Credentials recorded in HWMS Audit Logs.',
        ]);
    }

    public function resendStaffWelcome(User $user_id)
    {
        if ($user_id->role !== 'staff') {
            return back()->with('error', 'Target node is not a staff operative.');
        }

        $tempPassword = Str::random(10);
        $user_id->update([
            'password' => Hash::make($tempPassword),
            'must_change_password' => true,
        ]);

        try {
            Mail::to($user_id->email)->send(new StaffWelcomeEmail($user_id->name, $user_id->email, $tempPassword, auth()->user()));
            return back()->with('success', "Credentials re-synced and dispatched to {$user_id->email}.");
        } catch (\Exception $e) {
            \Log::warning("Resend staff welcome failed for {$user_id->email}: " . $e->getMessage());
            return back()->with('error', 'Synchronization signal failed to dispatch (SMTP failure).');
        }
    }

    public function destroyUser(\App\Models\User $user_id)
    {

        if ($user_id->id === auth()->id()) {
            return back()->withErrors('Self-termination is restricted. Another administrator must authorize this action.');
        }

        $typeName = ($user_id->role === 'staff') ? 'Operative' : 'User';
        $user_id->delete();

        if (request()->ajax()) {
            return response()->json(['message' => "$typeName '{$user_id->email}' purged from registry."]);
        }
        return back()->with('success', "$typeName '{$user_id->email}' has been removed.");
    }

    public function storeFloor(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'level' => 'required|integer|min:0',
        ]);

        Floor::create($request->only('name', 'level'));
        return back()->with('success', 'Floor "' . $request->name . '" created successfully.');
    }


    public function generateRooms(Request $request)
    {
        $request->validate([
            'floor_id' => 'required|exists:floors,id',
            'template_type' => 'required|in:private_attached,general_attached,public_washroom',
            'room_count' => 'required|integer|min:1|max:50',
            'manual_number' => 'nullable|string|max:100',
        ]);

        $floor = Floor::findOrFail($request->floor_id);
        $level = (int) $floor->level;


        $roomPrefix = $level === 0 ? 'G' : (string) $level;
        $pwPrefix = $level === 0 ? 'GPW' : 'PW' . $level;

        $created = 0;
        $baseNumber = $request->manual_number;

        $startIndex = 1;
        if (!$baseNumber) {
            $prefix = ($request->template_type === 'public_washroom') ? $pwPrefix : $roomPrefix;

            $existingNames = ($request->template_type === 'public_washroom')
                ? Washroom::where('floor_id', $floor->id)->pluck('room_number')->toArray()
                : Room::where('floor_id', $floor->id)->pluck('room_number')->toArray();

            $indices = collect($existingNames)
                ->filter(fn($n) => str_starts_with($n, $prefix))
                ->map(function ($n) use ($prefix) {
                    return (int) substr($n, strlen($prefix));
                })
                ->filter(fn($index) => $index > 0);

            if ($indices->isNotEmpty()) {
                $startIndex = $indices->max() + 1;
            }
        }

        for ($i = $startIndex; $i < $startIndex + $request->room_count; $i++) {

            if ($baseNumber) {
                $offset = $i - $startIndex + 1;
                $roomNumber = ($request->room_count == 1) ? $baseNumber : $baseNumber . '-' . str_pad($offset, 2, '0', STR_PAD_LEFT);
            } else {
                $prefix = ($request->template_type === 'public_washroom') ? $pwPrefix : $roomPrefix;
                $roomNumber = $prefix . str_pad($i, 2, '0', STR_PAD_LEFT);
            }

            if ($request->template_type === 'public_washroom') {

                if (Washroom::where('floor_id', $floor->id)->where('room_number', $roomNumber)->exists())
                    continue;
                Washroom::create([
                    'floor_id' => $floor->id,
                    'room_id' => null,
                    'type' => 'public',
                    'room_number' => $roomNumber,
                ]);
            } else {

                if (Room::where('floor_id', $floor->id)->where('room_number', $roomNumber)->exists())
                    continue;

                $type = ($request->template_type === 'private_attached') ? 'private' : 'general';
                $room = Room::create([
                    'floor_id' => $floor->id,
                    'room_number' => $roomNumber,
                    'room_name' => $roomNumber,
                    'type' => $type,
                    'has_attached_washroom' => true,
                ]);

                Washroom::create([
                    'floor_id' => $floor->id,
                    'room_id' => $room->id,
                    'room_number' => 'WR-' . $roomNumber,
                    'type' => 'attached',
                ]);
            }
            $created++;
        }

        return back()->with('success', "Successfully established {$created} facility units on {$floor->name}.");
    }

    public function updateFloor(Request $request, Floor $floor_id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'level' => 'required|integer',
        ]);

        $floor_id->update($request->only('name', 'level'));
        return back()->with('success', 'Floor context updated successfully.');
    }

    public function destroyFloor(Floor $floor_id)
    {

        Room::where('floor_id', $floor_id->id)->delete();
        Washroom::where('floor_id', $floor_id->id)->delete();
        $floor_id->delete();
        if (request()->ajax()) {
            return response()->json(['message' => "Floor '{$floor_id->name}' and all nested assets eradicated."]);
        }
        return back()->with('success', 'Floor and all nested units removed.');
    }

    public function updateRoom(Request $request, Room $room_id)
    {
        $request->validate([
            'room_number' => 'required|string|max:100',
            'room_name' => 'required|string|max:255',
            'type' => 'required|in:general,private',
        ]);

        $oldNumber = $room_id->room_number;
        $room_id->update($request->only('room_number', 'room_name', 'type'));

        if ($oldNumber !== $request->room_number) {
            Washroom::where('room_id', $room_id->id)
                ->where('room_number', 'WR-' . $oldNumber)
                ->update(['room_number' => 'WR-' . $request->room_number]);
        }

        return back()->with('success', "Facility unit {$room_id->room_number} updated.");
    }

    public function destroyRoom(Room $room_id)
    {

        Washroom::where('room_id', $room_id->id)->delete();
        $room_id->delete();
        if (request()->ajax()) {
            return response()->json(['message' => "Facility unit {$room_id->room_number} and attached assets removed."]);
        }
        return back()->with('success', 'Room and associated attached units removed.');
    }

    public function updateWashroom(Request $request, Washroom $washroom_id)
    {
        $request->validate([
            'room_number' => 'required|string|max:100',
        ]);

        $washroom_id->update($request->only('room_number'));
        return back()->with('success', 'Washroom asset updated.');
    }

    public function destroyWashroom(Washroom $washroom_id)
    {
        $washroom_id->delete();
        if (request()->ajax()) {
            return response()->json(['message' => "Standalone asset {$washroom_id->room_number} removed from grid."]);
        }
        return back()->with('success', 'Washroom unit removed.');
    }
    public function destroyTask(\App\Models\Task $task_id)
    {
        $task_id->delete();
        return back()->with('success', 'Operational task terminated.');
    }

    public function updateTask(Request $request, \App\Models\Task $task_id)
    {
        $request->validate(['status' => 'required|in:assigned,in_progress,completed']);
        $task_id->update(['status' => $request->status]);
        return back()->with('success', 'Task status synchronized.');
    }

    public function completeTask(\App\Models\Task $task_id)
    {
        $task_id->update(['status' => 'completed']);
        return back()->with('success', 'Task marked as completed.');
    }

    public function showComplaints(Request $request)
    {
        $query = \App\Models\Complaint::with(['user', 'floor', 'room', 'washroom']);


        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                    ->orWhere('complaint_type', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($uq) use ($search) {
                        $uq->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('floor', function ($fq) use ($search) {
                        $fq->where('name', 'like', "%{$search}%");
                    });
            });
        }


        if ($request->filled('status')) {
            $query->where('status', $request->status);
        } else {
            $query->whereIn('status', ['pending', 'in_progress']);
        }

        $complaints = $query->latest()->paginate(15)->withQueryString();

        $stats = [
            'total' => \App\Models\Complaint::count(),
            'pending' => \App\Models\Complaint::where('status', 'pending')->count(),
            'in_progress' => \App\Models\Complaint::where('status', 'in_progress')->count(),
            'resolved' => \App\Models\Complaint::where('status', 'resolved')->count(),
        ];

        return view('admin.complaints', compact('complaints', 'stats'));
    }

    public function bulkActionComplaints(Request $request)
    {
        $request->validate([
            'complaint_ids' => 'required|array',
            'action' => 'required|in:in_progress,resolved',
        ]);

        foreach ($request->complaint_ids as $id) {
            $complaint = \App\Models\Complaint::find($id);
            if ($complaint) {
                if ($request->action === 'resolved') {
                    $complaint->markAsResolved('Bulk resolution protocol initiated.');
                } else {
                    $complaint->markAsInProgress();
                }
            }
        }

        return response()->json(['success' => true]);
    }

    public function updateComplaintStatus(Request $request, \App\Models\Complaint $complaint_id)
    {
        $request->validate([
            'status' => 'required|in:pending,in_progress,resolved',
            'admin_notes' => 'nullable|string|max:1000'
        ]);

        $data = [
            'status' => $request->status,
            'admin_notes' => $request->admin_notes,
            'last_updated_by' => auth()->user()->name
        ];

        if ($request->status === 'resolved' && !$complaint_id->resolved_at) {
            $data['resolved_at'] = now();
        }

        $complaint_id->update($data);
        return back()->with('success', "Complaint status synchronized to {$request->status}.");
    }

    public function resolveComplaint(\App\Models\Complaint $complaint_id)
    {
        $complaint_id->update([
            'status' => 'resolved',
            'resolved_at' => now(),
            'last_updated_by' => auth()->user()->name
        ]);
        return back()->with('success', 'Complaint resolved successfully.');
    }

    public function printCleaningManifest()
    {

        $floors = \App\Models\Floor::with([
            'tasks' => function ($query) {
                $query->whereIn('status', ['pending', 'in_progress'])
                    ->with(['room', 'washroom', 'assignee']);
            }
        ])->orderBy('level', 'asc')->get();

        $admin = auth()->user();

        return view('admin.print-manifest', compact('floors', 'admin'));
    }

    public function printComplaints()
    {
        $complaints = \App\Models\Complaint::with(['user', 'floor', 'room', 'washroom'])
            ->whereIn('status', ['pending', 'in_progress'])
            ->latest()
            ->get();

        $generatedBy = auth()->user()->name;

        return view('complaints.print-all', compact('complaints', 'generatedBy'));
    }



    public function databaseUsers()
    {
        $data = \App\Models\User::latest()->paginate(10)->withQueryString();
        return view('admin.database.users', compact('data'));
    }

    public function databaseFloors()
    {
        $data = \App\Models\Floor::with(['rooms', 'washrooms'])->orderBy('level', 'asc')->paginate(10)->withQueryString();
        return view('admin.database.floors', compact('data'));
    }

    public function databaseRooms()
    {
        $data = \App\Models\Room::with('floor')->latest()->paginate(10)->withQueryString();
        return view('admin.database.rooms', compact('data'));
    }

    public function databaseWashrooms()
    {
        $data = \App\Models\Washroom::with(['floor', 'room'])->latest()->paginate(10)->withQueryString();
        return view('admin.database.washrooms', compact('data'));
    }

    public function databaseTasks()
    {
        $data = \App\Models\Task::with(['assignee', 'floor', 'room', 'washroom'])->latest()->paginate(10)->withQueryString();
        return view('admin.database.tasks', compact('data'));
    }

    public function databaseComplaints()
    {
        $data = \App\Models\Complaint::with(['user', 'floor', 'room', 'washroom'])->latest()->paginate(10)->withQueryString();
        return view('admin.database.complaints', compact('data'));
    }


    public function exportTasks()
    {
        $tasks = Task::with(['assignee', 'room', 'washroom', 'floor'])->latest()->get();
        $fileName = 'WMS_Tasks_Export_' . now()->format('Y-m-d') . '.csv';

        $headers = [
            'Content-type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=$fileName",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $columns = ['Task ID', 'Target Unit', 'Floor', 'Assigned To', 'Status', 'Created At'];

        $callback = function () use ($tasks, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            foreach ($tasks as $task) {
                fputcsv($file, [
                    (string) $task->id,
                    $task->room ? $task->room->room_number : ($task->washroom->room_number ?? 'Public Facility'),
                    $task->floor->name ?? 'Unknown',
                    $task->assignee->name ?? 'Unassigned',
                    $task->status,
                    $task->created_at->format('Y-m-d H:i:s'),
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }


    public function exportComplaints()
    {
        $complaints = \App\Models\Complaint::with(['user', 'floor', 'room', 'washroom'])->latest()->get();
        $fileName = 'WMS_Complaints_Export_' . now()->format('Y-m-d') . '.csv';

        $headers = [
            'Content-type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=$fileName",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $columns = ['Complaint ID', 'Reporter', 'Type', 'Location', 'Floor', 'Description', 'Status', 'Reported At', 'Evidence Link'];

        $callback = function () use ($complaints, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            foreach ($complaints as $c) {
                fputcsv($file, [
                    (string) $c->id,
                    $c->user->name ?? 'Anonymous',
                    $c->complaint_type ?? 'Other',
                    $c->room ? $c->room->room_number : ($c->washroom->room_number ?? 'Public Facility'),
                    $c->floor->name ?? 'Unknown',
                    $c->description ?: $c->message ?: '',
                    $c->status,
                    $c->created_at->format('Y-m-d H:i:s'),
                    $c->image_path ? url('storage/' . $c->image_path) : 'No Evidence'
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }


    public function exportFloors()
    {
        $floors = \App\Models\Floor::with(['rooms', 'washrooms'])->orderBy('level', 'asc')->get();
        $fileName = 'WMS_Floors_Export_' . now()->format('Y-m-d') . '.csv';

        $headers = [
            'Content-type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=$fileName",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $columns = ['Floor ID', 'Level', 'Name', 'Room Count', 'Washroom Count', 'Created At'];

        $callback = function () use ($floors, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            foreach ($floors as $floor) {
                fputcsv($file, [
                    (string) $floor->id,
                    $floor->level,
                    $floor->name,
                    $floor->rooms->count(),
                    $floor->washrooms->count(),
                    $floor->created_at->format('Y-m-d H:i:s'),
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
