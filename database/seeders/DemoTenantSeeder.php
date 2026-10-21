<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Room;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Seeder;

class DemoTenantSeeder extends Seeder
{
    public function run(): void
    {
        $phone = User::normalizePhone('081200000000');

        // `role` tidak di-fillable, jadi otomatis 'penyewa' (default database).
        // Nomor HP penyewa demo dipakai untuk login: 081200000000 / password.
        $user = User::firstOrCreate(
            ['phone' => $phone],
            [
                'name' => 'Penyewa Contoh',
                'password' => 'password', // di-hash oleh cast 'hashed'
            ]
        );

        $tenant = Tenant::firstOrCreate(
            ['user_id' => $user->id],
            [
                'phone' => $user->phone, // sama dengan users.phone
                'emergency_contact' => '081300000000',
                'campus_or_job' => 'Universitas Negeri Malang',
            ]
        );

        $room = Room::whereHas('building', fn ($q) => $q->where('segment', 'putra'))
            ->orderBy('number')
            ->first();

        Booking::firstOrCreate(
            ['tenant_id' => $tenant->id, 'room_id' => $room->id],
            [
                'package' => 'monthly',
                'start_date' => today()->subDays(10),
                'end_date' => today()->addDays(20),
                'total_price' => $room->price_monthly,
                'deposit_amount' => 200000,
                'status' => 'aktif',
            ]
        );
    }
}