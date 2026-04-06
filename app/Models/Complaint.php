<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'floor_id',
        'room_id',
        'washroom_id',
        'complaint_type',
        'description',
        'image_path',
        'status',
        'admin_notes',
        'resolved_at',
        'last_updated_by'
    ];

    protected $casts = [
        'resolved_at' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

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

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeInProgress($query)
    {
        return $query->where('status', 'in_progress');
    }

    public function scopeResolved($query)
    {
        return $query->where('status', 'resolved');
    }

    public function getLocationDisplay()
    {
        $parts = [];
        
        if ($this->floor) {
            $parts[] = $this->floor->name;
        }
        
        if ($this->room) {
            $parts[] = $this->room->room_number;
        }
        
        if ($this->washroom) {
            $parts[] = $this->washroom->room_number ?: $this->washroom->name;
        }
        
        return implode(' → ', $parts);
    }
}

