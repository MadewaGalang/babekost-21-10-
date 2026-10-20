<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tabel rental (penyewaan). Status mengikuti alur di bagian 4.3:
     * menunggu_pembayaran -> booking (DP terverifikasi) -> aktif (lunas,
     * masa sewa berjalan) -> selesai. Cabang: dibatalkan (oleh penyewa
     * atau otomatis saat belum lunas di hari mulai sewa -> DP hangus).
     *
     * Perpanjangan SELALU membuat row baru (bukan update row lama) agar
     * riwayat & laporan tetap bersih (bagian 4.4) — karena itu TIDAK ada
     * kolom "parent_rental_id"; tampilan "Kos Saya" cukup query semua
     * rental milik tenant_id yang sama, diurutkan tanggal.
     *
     * Index (room_id, start_date, end_date) dipakai saat Hari 8 nanti
     * untuk cek ketersediaan kamar berdasarkan rentang tanggal.
     */
    public function up(): void
    {
        Schema::create('rentals', function (Blueprint $table) {
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
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['room_id', 'start_date', 'end_date'], 'rentals_availability_index');
            $table->index(['tenant_id'], 'rentals_tenant_index');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rentals');
    }
};
