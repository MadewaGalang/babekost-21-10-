<?php

namespace Database\Seeders;

use App\Models\Building;
use App\Models\Room;
use Illuminate\Database\Seeder;

class BabeKostDataSeeder extends Seeder
{
    // ASUMSI: harga sama untuk semua kamar. Ganti sesuai harga sebenarnya.
    private const PRICE_MONTHLY   = 600000;
    private const PRICE_QUARTERLY = 1700000;
    private const PRICE_YEARLY    = 6500000;

    public function run(): void
    {
        $joyoSari = 'Jl. Joyo Sari RT 06 RW 05, Merjosari, Kec. Lowokwaru, Kota Malang';

        // [nama gedung, alamat, jumlah kamar, awalan kode kamar]
        $buildings = [
            ['Rumah 26 F', $joyoSari, 6, 'F'],
            ['Rumah 26 H', $joyoSari, 6, 'H'],
            ['Rumah 26 G', $joyoSari, 9, 'G'],
            ['Rumah 26 I', $joyoSari, 8, 'I'],
            ['Kost Candi Badut', 'Jl. Raya Candi Blok VA No.111 RT 03 RW 05, Karang Besuki, Sukun, Kota Malang', 9, 'C'],
            ['Kost Joyo Utomo', 'Jl. Joyo Utomo No.429 RT 01 RW 04, Merjosari, Kec. Lowokwaru, Kota Malang', 6, 'J'],
            ['Kost Kanjuruhan', 'Jl. Kanjuruhan Asri Blok D.13 RT 05 RW 03, Tlogomas, Kec. Lowokwaru, Kota Malang', 3, 'K'],
            ['Babe Kost Tlogomas', 'Jl. Tlogosari No.643 A RT 03 RW 05, Merjosari, Kec. Lowokwaru, Kota Malang', 17, 'T'],
        ];

        foreach ($buildings as [$name, $address, $count, $prefix]) {
            // ASUMSI: semua bangunan putra.
            $building = Building::create([
                'name'    => $name,
                'address' => $address,
                'segment' => 'putra',
            ]);

            for ($i = 1; $i <= $count; $i++) {
                Room::create([
                    'building_id'     => $building->id,
                    'number'          => $prefix . $i,
                    'capacity'        => 1,
                    'price_monthly'   => self::PRICE_MONTHLY,
                    'price_quarterly' => self::PRICE_QUARTERLY,
                    'price_yearly'    => self::PRICE_YEARLY,
                ]);
            }
        }
    }
}