<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tabel kamar. `number` wajib unik PER LOKASI, tapi nomor yang
     * sudah di-soft-delete harus bisa dipakai ulang (lihat bagian 10).
     * Dipakai pola yang sama seperti tabel users: kolom generated
     * `number_sort` (0 jika aktif, timestamp hapus jika sudah di-soft-
     * delete) lalu unique index pada (location_id, number, number_sort).
     *
     * Catatan: kolom `special_status` HANYA untuk kondisi khusus
     * (misalnya kamar sedang diperbaiki). Ketersediaan kamar untuk
     * disewa dihitung dari rentang tanggal rental yang aktif/booking,
     * BUKAN dari kolom ini (bagian 3 & 6).
     */
    public function up(): void
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('location_id')->constrained()->cascadeOnDelete();
            $table->string('number');
            $table->string('type')->nullable();
            $table->json('facilities')->nullable();
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
                ['location_id', 'number', 'number_sort'],
                'rooms_location_number_active_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
