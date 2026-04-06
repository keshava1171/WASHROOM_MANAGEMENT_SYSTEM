<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Floor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'level'
    ];

    public function rooms()
    {
        return $this->hasMany(Room::class);
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

    public function getFloorDisplayAttribute()
    {
        return $this->name . ' (L' . ($this->level == 0 ? 'G' : $this->level) . ')';
    }
}

