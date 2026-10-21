<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * `receipt_number` nullable: baru diisi saat admin memverifikasi.
     * `verified_by` menunjuk ke admin yang memverifikasi.
     * `proof_path` menunjuk ke private storage.
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained()->restrictOnDelete();
            $table->foreignId('verified_by')->nullable()
                ->constrained('admins')->nullOnDelete();
            $table->string('receipt_number')->nullable();
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