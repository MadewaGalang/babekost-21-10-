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
        // `role` tidak di-fillable, jadi otomatis 'penyewa' (default database).
        $user = User::create([
            'name' => 'Penyewa Contoh',
            'email' => 'penyewa@babekost.test',
            'password' => 'password',
        ]);

        $tenant = Tenant::create([
            'user_id' => $user->id,
            'phone' => '081200000000',
            'emergency_contact' => '081300000000',
            'campus_or_job' => 'Universitas Negeri Malang',
        ]);

        $room = Room::whereHas('building', fn ($q) => $q->where('segment', 'putra'))
            ->orderBy('number')
            ->first();

        Booking::create([
            'tenant_id' => $tenant->id,
            'room_id' => $room->id,
            'package' => 'monthly',
            'start_date' => today()->subDays(10),
            'end_date' => today()->addDays(20),
            'total_price' => $room->price_monthly,
            'deposit_amount' => 200000,
            'status' => 'aktif',
        ]);
    }
}