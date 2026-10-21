<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * `number` unik per bangunan; nomor yang sudah di-soft-delete bisa
     * dipakai ulang (kolom generated number_sort).
     * `special_status` hanya untuk kondisi khusus. Ketersediaan kamar
     * dihitung dari rentang tanggal booking, bukan dari kolom ini.
     */
    public function up(): void
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('building_id')->constrained()->cascadeOnDelete();
            $table->string('number');
            $table->string('type')->nullable();
            $table->unsignedBigInteger('price_monthly');
            $table->unsignedBigInteger('price_quarterly');
            $table->unsignedBigInteger('price_yearly');
            $table->enum('special_status', ['normal', 'perbaikan', 'nonaktif'])
                ->default('normal');
            $table->timestamps();
            $table->dateTime('deleted_at')->nullable();
        });

        Schema::table('rooms', function (Blueprint $table) {
            $table->unsignedBigInteger('number_sort')
                ->storedAs('IF(`deleted_at` IS NULL, 0, TO_SECONDS(`deleted_at`))')
                ->after('deleted_at');
            $table->unique(
                ['building_id', 'number', 'number_sort'],
                'rooms_building_number_active_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};