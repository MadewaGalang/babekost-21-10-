<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menyesuaikan tabel `users` bawaan Breeze untuk kebutuhan Babekost:
     *  - role: admin (pemilik, 1 akun saja, dibuat lewat seeder) / penyewa
     *    (daftar sendiri lewat halaman publik). Registrasi admin TIDAK
     *    tersedia untuk umum (lihat bagian 2 dokumen perencanaan).
     *  - soft delete: agar akun yang terhapus tidak langsung hilang.
     *  - unique email yang "sadar" soft delete: constraint unique bawaan
     *    MySQL pada (email) akan tetap memblokir email yang sudah pernah
     *    dipakai walau user lamanya sudah di-soft-delete, karena NULL di
     *    kolom deleted_at tidak dianggap unik secara otomatis oleh indeks.
     *    Solusinya: tambah kolom generated `email_sort` yang bernilai 0
     *    untuk akun aktif dan UNIX timestamp waktu hapus untuk akun yang
     *    sudah di-soft-delete, lalu index unique dipasang pada
     *    (email, email_sort). Ini membuat SEMUA akun aktif tetap wajib
     *    unik di kolom email (karena email_sort mereka sama-sama 0),
     *    sementara email yang sudah di-soft-delete bebas dipakai ulang.
     *    Pola composite-unique + generated-column ini dipakai ulang di
     *    tabel rooms (nomor kamar per lokasi) dan payments (nomor
     *    kwitansi) — lihat komentar di migration masing-masing.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
        $table->enum('role', ['admin', 'penyewa'])
        ->default('penyewa')
        ->after('password');
        $table->dateTime('deleted_at')->nullable();
        });

        // Lepas unique index bawaan Laravel pada email supaya bisa diganti
        // dengan versi yang sadar soft-delete di bawah.
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique('users_email_unique');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('email_sort')
            ->storedAs('IF(`deleted_at` IS NULL, 0, TO_SECONDS(`deleted_at`))')
            ->after('deleted_at');
            $table->unique(['email', 'email_sort'], 'users_email_active_unique');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique('users_email_active_unique');
            $table->dropColumn('email_sort');
            $table->dropSoftDeletes();
            $table->dropColumn('role');
            $table->unique('email', 'users_email_unique');
        });
    }
};
