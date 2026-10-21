<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Membuat SATU akun admin (pemilik): satu baris di `users` (role=admin)
     * dan satu baris profil di `admins`. Registrasi admin TIDAK tersedia
     * untuk umum, jadi akun ini satu-satunya jalan masuk.
     *
     * Kredensial dari .env (ADMIN_PHONE / ADMIN_USERNAME / ADMIN_PASSWORD /
     * ADMIN_EMAIL opsional). Idempotent: aman dijalankan ulang.
     */
    public function run(): void
    {
        $phone    = User::normalizePhone(env('ADMIN_PHONE', '081234567890'));
        $username = env('ADMIN_USERNAME', 'admin');
        $email    = env('ADMIN_EMAIL'); // opsional, boleh kosong
        $password = env('ADMIN_PASSWORD', 'babekost-admin-passphrase');

        // Kunci pencarian: nomor HP (identitas login utama).
        $user = User::withTrashed()->firstOrNew(['phone' => $phone]);
        $user->forceFill([
            'name'      => 'Pemilik Babekost',
            'username'  => $username,
            'email'     => $email ?: null,
            'password'  => $password, // di-hash oleh cast 'hashed'
            'role'      => 'admin',
            'is_active' => true,
            'deleted_at' => null,
        ])->save();

        $admin = Admin::withTrashed()->firstOrNew(['user_id' => $user->id]);
        $admin->forceFill([
            'phone'      => $user->phone, // salin dari users agar tidak berbeda
            'deleted_at' => null,
        ])->save();

        $this->command?->info("Akun admin siap: {$username} / {$phone}");
        if (! env('ADMIN_PASSWORD')) {
            $this->command?->warn(
                'ADMIN_PASSWORD belum diset di .env, memakai password default. '
                . 'Ganti sebelum deploy!'
            );
        }
    }
}