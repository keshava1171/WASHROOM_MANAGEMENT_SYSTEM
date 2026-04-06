<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    public function store(Request $request)
    {

        $input = $request->all();
        if (empty($input['room_id'])) $input['room_id'] = null;
        if (empty($input['washroom_id'])) $input['washroom_id'] = null;

        $request->merge($input);

        $request->validate([
            'floor_id' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (!\App\Models\Floor::find($value)) {
                        $fail('The selected floor is invalid.');
                    }
                },
            ],
            'room_id' => [
                'nullable',
                function ($attribute, $value, $fail) {
                    if ($value && !\App\Models\Room::find($value)) {
                        $fail('The selected room id is invalid.');
                    }
                },
            ],
            'washroom_id' => 'nullable|exists:washrooms,id',
            'assigned_to' => 'required|exists:users,id',
        ]);

        Task::create([
            'floor_id' => $request->floor_id,
            'room_id' => $request->room_id,
            'washroom_id' => $request->washroom_id,
            'assigned_to' => $request->assigned_to,
            'assigned_by' => auth()->id(),
            'status' => 'pending'
        ]);

        return back()->with('success', 'Task successfully assigned to staff.');
    }

    public function bulkStore(Request $request)
    {
        $request->validate([
            'assigned_to' => 'required|exists:users,id',
            'selections' => 'required|array',
            'selections.*.floor_id' => 'required',
            'selections.*.type' => 'required|in:room,public_washroom',
        ]);

        foreach ($request->selections as $selection) {
            $roomId = null;
            $washroomId = null;

            if ($selection['type'] === 'room') {
                $roomId = $selection['id'];

                $attachedWr = \App\Models\Washroom::where('room_id', $roomId)->first();
                $washroomId = $attachedWr ? $attachedWr->id : null;
            } else {

                $washroomId = $selection['id'];
            }

            Task::create([
                'floor_id' => $selection['floor_id'],
                'room_id' => $roomId,
                'washroom_id' => $washroomId,
                'assigned_to' => $request->assigned_to,
                'assigned_by' => auth()->id(),
                'status' => 'pending'
            ]);
        }

        return response()->json(['success' => true, 'message' => count($request->selections) . ' tasks successfully dispatched.']);
    }

    public function update(Request $request, $id)
    {

        $task = Task::where('id', $id)->where('assigned_to', auth()->id())->firstOrFail();
        
        $request->validate([
            'status' => 'required|in:completed'
        ]);

        $task->update(['status' => 'completed']);

        return back()->with('success', 'Task marked as completed.');
    }

    public function bulkUpdate(Request $request)
    {
        $request->validate([
            'task_ids' => 'required|array',
            'task_ids.*' => 'exists:tasks,id'
        ]);

        $count = Task::whereIn('id', $request->task_ids)
            ->where('assigned_to', auth()->id())
            ->where('status', 'pending')
            ->update(['status' => 'completed']);

        return response()->json([
            'success' => true,
            'message' => "LOGISTICS: {$count} task nodes finalized successfully."
        ]);
    }
}

