<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Membuat SATU akun admin (pemilik) secara otomatis. Sesuai bagian 2:
     * registrasi admin TIDAK tersedia untuk umum — akun ini satu-satunya
     * jalan masuk, dipakai bersama oleh suami & istri di dua perangkat.
     *
     * Kredensial diambil dari .env supaya tidak ter-hardcode di kode
     * (lihat ADMIN_EMAIL / ADMIN_PASSWORD di .env.example). Memakai
     * updateOrCreate agar seeder aman dijalankan ulang (idempotent).
     */
    public function run(): void
    {
        $email = env('ADMIN_EMAIL', 'pemilik@babekost.test');
        $password = env('ADMIN_PASSWORD', 'babekost-admin-passphrase');

        User::withTrashed()->updateOrCreate(
            ['email' => $email],
            [
                'name' => 'Pemilik Babekost',
                'password' => Hash::make($password),
                'role' => 'admin',
                'email_verified_at' => now(),
                'deleted_at' => null,
            ]
        );

        $this->command?->info("Akun admin siap: {$email}");
        if (! env('ADMIN_PASSWORD')) {
            $this->command?->warn(
                'ADMIN_PASSWORD belum diset di .env — memakai password default. '
                . 'Ganti sebelum deploy!'
            );
        }
    }
}
