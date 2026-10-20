<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tabel bangunan/lokasi kos. Satu bangunan hanya melayani SATU
     * segmen (putra atau putri) — tidak ada kos campur, sesuai
     * keputusan desain di bagian 6 & 11 dokumen perencanaan.
     */
    public function up(): void
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('address');
            $table->enum('segment', ['putra', 'putri']);
            $table->timestamps();
            $table->softDeletes(); // data penting -> soft delete (bagian 10)
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};
