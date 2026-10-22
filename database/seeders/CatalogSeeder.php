<?php

namespace Database\Seeders;

use App\Models\Agenda;
use App\Models\Facility;
use App\Models\Promo;
use Illuminate\Database\Seeder;

class CatalogSeeder extends Seeder
{
    public function run(): void
    {
        foreach (['Kasur', 'Lemari', 'Meja belajar', 'WiFi', 'Kamar mandi dalam'] as $name) {
            Facility::create(['name' => $name]);
        }

        Promo::create([
            'title'       => 'Diskon sewa tahunan',
            'description' => 'Potongan khusus untuk sewa 12 bulan',
            'is_active'   => true,
        ]);

        Agenda::create([
            'title'       => 'Santunan anak yatim',
            'agenda_date' => '2026-11-20',
            'description' => 'Pembagian santunan di aula kos bersama penghuni',
            'status'      => 'rencana',
        ]);
    }
}