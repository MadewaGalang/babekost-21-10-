<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Akun admin dibutuhkan di semua lingkungan (lokal maupun server).
        $this->call(AdminUserSeeder::class);

        // Data contoh hanya untuk pengembangan lokal.
        if (app()->environment('local')) {
            $this->call([
                CatalogSeeder::class,     // bangunan, kamar, fasilitas
                DemoTenantSeeder::class,  // penyewa dan booking contoh
            ]);
        }
    }
}