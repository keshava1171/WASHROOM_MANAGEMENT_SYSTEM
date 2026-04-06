<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('washrooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('floor_id')->constrained()->onDelete('cascade');
            $table->foreignId('room_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('name')->nullable();
            $table->string('room_number')->nullable();
            $table->enum('type', ['public', 'attached'])->default('public');
            $table->enum('status', ['active', 'maintenance', 'out_of_service'])->default('active');
            $table->timestamps();
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('washrooms');
    }
};

