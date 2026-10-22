<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AdminUserSeeder::class,
            CatalogSeeder::class,
            BabeKostDataSeeder::class,
        ]);
        $user = \App\Models\User::create([
            'name'     => 'Penyewa Uji',
            'phone'    => '081200000001',
            'password' => 'password123',
        ]);
        $user->tenant()->create(['phone' => $user->phone]);
    }
}