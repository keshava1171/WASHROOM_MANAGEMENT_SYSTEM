<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Washroom extends Model
{
    use HasFactory;

    protected $fillable = [
        'floor_id',
        'room_id',
        'name',
        'room_number',
        'type',
        'status'
    ];

    public function floor()
    {
        return $this->belongsTo(Floor::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
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

