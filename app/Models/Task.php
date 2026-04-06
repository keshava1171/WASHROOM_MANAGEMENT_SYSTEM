<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'floor_id',
        'room_id',
        'washroom_id',
        'assigned_to',
        'status',
        'completed_at'
    ];

    protected $casts = [
        'completed_at' => 'datetime'
    ];

    public function floor()
    {
        return $this->belongsTo(Floor::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function washroom()
    {
        return $this->belongsTo(Washroom::class);
    }

    public function assignee()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function markAsCompleted()
    {
        $this->update([
            'status'       => 'completed',
            'completed_at' => now(),
        ]);
    }

    public function markAsInProgress()
    {
        $this->update([
            'status' => 'in_progress',
        ]);
    }
}

