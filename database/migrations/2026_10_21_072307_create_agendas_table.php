<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /** Agenda dan dokumentasi kegiatan santunan. */
    public function up(): void
    {
        Schema::create('agendas', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->date('agenda_date');
            $table->text('description')->nullable();
            $table->string('documentation_path')->nullable();
            $table->enum('status', ['rencana', 'selesai'])->default('rencana');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agendas');
    }
};