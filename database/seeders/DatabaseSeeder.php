<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seeder user admin — wajib dijalankan lebih dulu
        $this->call([
            AdminUserSeeder::class,
            // Seeder data lokasi/kamar contoh ditambahkan di Hari 5-6,
            // setelah CRUD bangunan & kamar ada.
        ]);

        // User dummy untuk testing/development lokal
        User::factory()->create([
            'name'  => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}