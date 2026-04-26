<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Floor;
use App\Models\Room;
use App\Models\Washroom;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    
    public function run(): void
    {
        $admin = User::create([
            'name' => 'System Administrator',
            'email' => 'admin@wms.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'email_verified_at' => now(),
            'must_change_password' => true,
        ]);

        $basement = Floor::create(['name' => 'Basement / Logistics', 'level' => -1]);
        $ground = Floor::create(['name' => 'Main Reception / ER', 'level' => 0]);
        $first = Floor::create(['name' => 'General Ward', 'level' => 1]);

        Room::create([
            'floor_id' => $ground->id,
            'room_number' => 'G101',
            'type' => 'general',
            'status' => 'active'
        ]);

        $privateRoom = Room::create([
            'floor_id' => $first->id,
            'room_number' => '101',
            'type' => 'private',
            'status' => 'active'
        ]);

        Washroom::create([
            'floor_id' => $ground->id,
            'name' => 'Main Entrance Public Washroom',
            'room_number' => 'GPW1',
            'type' => 'public',
            'status' => 'active'
        ]);

        Washroom::create([
            'floor_id' => $first->id,
            'room_id' => $privateRoom->id,
            'name' => 'Attached Washroom 101',
            'room_number' => '101A',
            'type' => 'attached',
            'status' => 'active'
        ]);
    }
}

