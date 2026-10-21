<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /** Pivot many-to-many fasilitas dan kamar (Fasilitas_Kamar di ERD). */
    public function up(): void
    {
        Schema::create('facility_room', function (Blueprint $table) {
            $table->foreignId('facility_id')->constrained()->cascadeOnDelete();
            $table->foreignId('room_id')->constrained()->cascadeOnDelete();
            $table->unsignedSmallInteger('quantity')->default(1);
            $table->string('condition')->nullable();
            $table->string('notes')->nullable();
            $table->primary(['facility_id', 'room_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('facility_room');
    }
};