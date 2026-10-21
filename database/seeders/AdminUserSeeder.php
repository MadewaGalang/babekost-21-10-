<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Membuat SATU akun admin (pemilik): satu baris di `users` (role=admin)
     * dan satu baris profil di `admins`. Registrasi admin TIDAK tersedia
     * untuk umum, jadi akun ini satu-satunya jalan masuk.
     *
     * Kredensial dari .env (ADMIN_EMAIL / ADMIN_PASSWORD / ADMIN_PHONE).
     * Idempotent: aman dijalankan ulang.
     */
    public function run(): void
    {
        $email = env('ADMIN_EMAIL', 'pemilik@babekost.test');
        $password = env('ADMIN_PASSWORD', 'babekost-admin-passphrase');
        $phone = env('ADMIN_PHONE', '081234567890');

        $user = User::withTrashed()->firstOrNew(['email' => $email]);
        $user->forceFill([
            'name' => 'Pemilik Babekost',
            'password' => Hash::make($password),
            'role' => 'admin',
            'email_verified_at' => now(),
            'deleted_at' => null,
        ])->save();

        $admin = Admin::withTrashed()->firstOrNew(['user_id' => $user->id]);
        $admin->forceFill([
            'phone' => $phone,
            'deleted_at' => null,
        ])->save();

        $this->command?->info("Akun admin siap: {$email}");
        if (! env('ADMIN_PASSWORD')) {
            $this->command?->warn(
                'ADMIN_PASSWORD belum diset di .env, memakai password default. '
                . 'Ganti sebelum deploy!'
            );
        }
    }
}