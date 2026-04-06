<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'floor_id',
        'room_number',
        'room_name',
        'type',
        'has_attached_washroom',
        'status'
    ];

    public function floor()
    {
        return $this->belongsTo(Floor::class);
    }

    public function washrooms()
    {
        return $this->hasMany(Washroom::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function complaints()
    {
        return $this->hasMany(Complaint::class);
    }
}

