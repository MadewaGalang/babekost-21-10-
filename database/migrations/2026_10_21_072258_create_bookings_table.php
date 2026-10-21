<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Alur status: menunggu_pembayaran -> booking (DP terverifikasi)
     * -> aktif (lunas) -> selesai. Cabang: dibatalkan.
     * Perpanjangan selalu membuat row baru. `cleaned_at` menandai
     * pembersihan H+1 setelah masa sewa berakhir sudah dilakukan.
     */
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained()->restrictOnDelete();
            $table->foreignId('room_id')->constrained()->restrictOnDelete();
            $table->enum('package', ['monthly', 'quarterly', 'yearly']);
            $table->date('start_date');
            $table->date('end_date');
            $table->unsignedBigInteger('total_price');
            $table->unsignedBigInteger('deposit_amount');
            $table->enum('status', [
                'menunggu_pembayaran',
                'booking',
                'aktif',
                'selesai',
                'dibatalkan',
            ])->default('menunggu_pembayaran');
            $table->timestamp('house_rules_agreed_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->string('cancellation_reason')->nullable();
            $table->timestamp('cleaned_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['room_id', 'start_date', 'end_date'], 'bookings_availability_index');
            $table->index(['tenant_id'], 'bookings_tenant_index');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};