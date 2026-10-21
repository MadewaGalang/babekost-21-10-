<?php

namespace Database\Seeders;

use App\Models\Building;
use App\Models\Facility;
use App\Models\Room;
use Illuminate\Database\Seeder;

class CatalogSeeder extends Seeder
{
    public function run(): void
    {
        $buildings = [
            Building::create([
                'name' => 'Babekost Putra',
                'address' => 'Jl. Contoh No. 1, Malang',
                'segment' => 'putra',
            ]),
            Building::create([
                'name' => 'Babekost Putri',
                'address' => 'Jl. Contoh No. 2, Malang',
                'segment' => 'putri',
            ]),
        ];

        $facilities = collect([
            'Kasur', 'Lemari', 'Meja belajar', 'WiFi', 'Kamar mandi dalam',
        ])->map(fn ($name) => Facility::create(['name' => $name]));

        foreach ($buildings as $building) {
            foreach (range(1, 5) as $i) {
                $hasBathroom = $i > 3;
                $monthly = $hasBathroom ? 800000 : 600000; // harga contoh, ganti dengan harga asli

                $room = Room::create([
                    'building_id' => $building->id,
                    'number' => (string) (100 + $i),
                    'type' => $hasBathroom ? 'Kamar mandi dalam' : 'Standar',
                    'price_monthly' => $monthly,
                    'price_quarterly' => (int) round($monthly * 3 * 0.95),
                    'price_yearly' => (int) round($monthly * 12 * 0.90),
                ]);

                // Kamar standar: 4 fasilitas pertama; kamar mandi dalam: semuanya.
                $room->facilities()->attach(
                    $facilities->take($hasBathroom ? 5 : 4)->pluck('id')
                );
            }
        }
    }
}