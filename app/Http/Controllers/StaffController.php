<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Complaint;
use App\Models\Floor;

class StaffController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();

        // Tasks grouped by floor for the stats counter
        $tasks = Task::with(['floor', 'room', 'washroom'])
            ->where('assigned_to', $user->id)
            ->get()
            ->sortBy(fn($t) => $t->floor->level ?? 999)
            ->groupBy(fn($t) => $t->floor->name ?? 'GENERAL GRID');

        // Full facility floors with rooms & washrooms (mirrors admin grid)
        $floors = Floor::with([
            'rooms' => fn($q) => $q->orderBy('room_number'),
            'washrooms' => fn($q) => $q->orderBy('room_number'),
        ])->orderBy('level')->get();

        // My active tasks keyed by room_id / washroom_id for status colouring
        $myTasks = Task::where('assigned_to', $user->id)
            ->whereIn('status', ['pending', 'assigned', 'in_progress'])
            ->get();

        // Annotate rooms and washrooms with task status
        $floors->each(function ($floor) use ($myTasks) {
            foreach ($floor->rooms as $room) {
                $t = $myTasks->firstWhere('room_id', $room->id);
                $room->taskStatus = $t ? $t->status : null;
                $room->taskId    = $t ? $t->id : null;
            }
            foreach ($floor->washrooms as $washroom) {
                $t = $myTasks->firstWhere('washroom_id', $washroom->id);
                $washroom->taskStatus = $t ? $t->status : null;
                $washroom->taskId    = $t ? $t->id : null;
            }
        });

        $stats = [
            'pending_tasks'    => Task::where('assigned_to', $user->id)->where('status', 'pending')->count(),
            'in_progress_tasks'=> Task::where('assigned_to', $user->id)->where('status', 'in_progress')->count(),
            'completed_tasks'  => Task::where('assigned_to', $user->id)->where('status', 'completed')->count(),
            'total_complaints' => Complaint::whereIn('status', ['pending', 'in_progress'])->count(),
        ];

        return view('staff.dashboard', compact('tasks', 'floors', 'stats'));
    }

    public function tasks()
    {
        $tasks = Task::with(['floor', 'room', 'washroom'])
            ->where('assigned_to', auth()->id())
            ->latest()
            ->paginate(15);

        return view('staff.tasks', compact('tasks'));
    }

    public function startTask(Task $task)
    {

        if ($task->assigned_to !== auth()->id()) {
            abort(403);
        }

        $task->markAsInProgress();
        return back()->with('success', 'Task started successfully!');
    }

    public function completeTask(Task $task)
    {

        if ($task->assigned_to != auth()->id()) {
            abort(403);
        }

        $task->markAsCompleted();
        return back()->with('success', 'Task completed successfully!');
    }

    public function bulkCompleteTasks(Request $request)
    {
        $request->validate([
            'selections' => 'required|array',
            'selections.*.id' => 'required',
            'selections.*.type' => 'required|in:room,public',
            'selections.*.floor_id' => 'required',
        ]);

        foreach ($request->selections as $selection) {
            if (!empty($selection['task_id'])) {
                $task = Task::find($selection['task_id']);
                if ($task && $task->assigned_to == auth()->id()) {
                    $task->markAsCompleted();
                }
            } else {
                // Ad-hoc task completion: Create a completed task record instantly for tracking
                $data = [
                    'floor_id' => $selection['floor_id'],
                    'assigned_to' => auth()->id(),
                    'status' => 'completed',
                ];
                
                if ($selection['type'] === 'public') {
                    $data['room_id'] = null;
                    $data['washroom_id'] = $selection['id'];
                } else {
                    $data['room_id'] = $selection['id'];
                    $data['washroom_id'] = null;
                }
                
                $task = Task::create($data);
                $task->markAsCompleted();
            }
        }

        return response()->json(['success' => true]);
    }

    public function printManifest()
    {
        $user = auth()->user();

        // Load all non-completed tasks for this staff member, sorted by floor level
        $tasksByFloor = Task::with(['floor', 'room', 'washroom'])
            ->where('assigned_to', $user->id)
            ->get()
            ->sortBy(fn($t) => $t->floor->level ?? 999)
            ->groupBy(fn($t) => $t->floor->name ?? 'GENERAL');

        $staff = $user;

        return view('staff.print-manifest', compact('tasksByFloor', 'staff'));
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

    public function complaints(Request $request)
    {
        $query = Complaint::with(['user', 'floor', 'room', 'washroom']);


        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                    ->orWhere('complaint_type', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($uq) use ($search) {
                        $uq->where('name', 'like', "%{$search}%");
                    });
            });
        }


        if ($request->filled('status')) {
            $query->where('status', $request->status);
        } else {

            $query->whereIn('status', ['pending', 'in_progress']);
        }

        $complaints = $query->latest()->paginate(15)->withQueryString();

        return view('staff.complaints', compact('complaints'));
    }

    public function bulkActionComplaints(Request $request)
    {
        $request->validate([
            'complaint_ids' => 'required|array',
            'action' => 'required|in:in_progress,resolved',
        ]);

        foreach ($request->complaint_ids as $id) {
            $complaint = Complaint::find($id);
            if ($complaint) {
                if ($request->action === 'resolved') {
                    $complaint->markAsResolved('Bulk resolution protocol initiated by Staff.');
                } else {
                    $complaint->markAsInProgress();
                }
            }
        }

        return response()->json(['success' => true]);
    }

    public function startComplaint(Complaint $complaint)
    {
        $complaint->markAsInProgress();
        return back()->with('success', 'Complaint marked as in progress!');
    }

    public function resolveComplaint(Request $request, Complaint $complaint)
    {
        $validated = $request->validate([
            'notes' => 'nullable|string|max:1000',
            'status' => 'required|in:in_progress,resolved'
        ]);

        $data = [
            'admin_notes' => $validated['notes'] ?? $complaint->admin_notes,
            'status' => $validated['status'],
            'last_updated_by' => auth()->user()->name
        ];

        if ($validated['status'] === 'resolved' && !$complaint->resolved_at) {
            $data['resolved_at'] = now();
        }

        $complaint->update($data);
        return back()->with('success', 'Complaint protocol updated successfully!');
    }

}

