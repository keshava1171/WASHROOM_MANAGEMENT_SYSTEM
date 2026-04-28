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
    }
}

