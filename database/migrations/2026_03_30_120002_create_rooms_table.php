<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('floor_id')->constrained()->onDelete('cascade');
            $table->string('room_number');
            $table->enum('type', ['general', 'private'])->default('general');
            $table->enum('status', ['active', 'maintenance', 'out_of_service'])->default('active');
            $table->timestamps();
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};

