<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tabel pembayaran. `receipt_number` dibuat unik dengan pola yang
     * sama seperti users/rooms (kolom generated `receipt_sort`) supaya
     * nomor kwitansi yang sudah di-soft-delete (misal input keliru lalu
     * dihapus admin) bisa dipakai ulang tanpa bentrok (bagian 10).
     *
     * `destination_account` mencatat ke rekening siapa (suami/istri)
     * transfer dilakukan — berlaku sama untuk semua kamar & lokasi
     * (bagian 4.1). `proof_path` menunjuk ke file di private storage,
     * bukan public disk (bagian 7 Stack: Laravel private storage).
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rental_id')->constrained()->restrictOnDelete();
            $table->string('receipt_number');
            $table->enum('type', ['dp', 'pelunasan']);
            $table->unsignedBigInteger('amount');
            $table->date('paid_at');
            $table->enum('destination_account', ['suami', 'istri']);
            $table->string('proof_path');
            $table->enum('status', ['menunggu_verifikasi', 'terverifikasi', 'ditolak'])
                ->default('menunggu_verifikasi');
            $table->string('rejection_reason')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->dateTime('deleted_at')->nullable();
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->unsignedBigInteger('receipt_sort')
            ->storedAs('IF(`deleted_at` IS NULL, 0, TO_SECONDS(`deleted_at`))')
            ->after('deleted_at');
            $table->unique(
                ['receipt_number', 'receipt_sort'],
                'payments_receipt_number_active_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
