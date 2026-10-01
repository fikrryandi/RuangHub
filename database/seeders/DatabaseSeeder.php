<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Department;
use App\Models\Room;
use App\Models\Booking;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Departments
        $depts = ['Produksi', 'PPIC', 'HRD', 'Finance', 'IT', 'Marketing', 'Purchasing'];
        foreach ($depts as $dept) {
            Department::create(['name' => $dept]);
        }
        
        // 2. Users
        // Admin
        User::create([
            'nip' => 'ADM001',
            'name' => 'Super Admin',
            'email' => 'admin@ruanghub.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'department_id' => 5 // IT
        ]);

        // Approvers
        $approvers = [];
        for ($i = 1; $i <= 3; $i++) {
            $approvers[] = User::create([
                'nip' => 'APP00' . $i,
                'name' => 'Approver ' . $i,
                'email' => "approver$i@ruanghub.com",
                'password' => Hash::make('password'),
                'role' => 'approver',
                'department_id' => $i // 1, 2, 3
            ]);
        }

        // Karyawan
        $karyawans = [];
        for ($i = 1; $i <= 15; $i++) {
            $karyawans[] = User::create([
                'nip' => 'EMP0' . str_pad($i, 2, '0', STR_PAD_LEFT),
                'name' => 'Karyawan ' . $i,
                'email' => "karyawan$i@ruanghub.com",
                'password' => Hash::make('password'),
                'role' => 'karyawan',
                'department_id' => rand(1, 7)
            ]);
        }

        // 3. Rooms
        $roomNames = ['Meeting Room A', 'Meeting Room B', 'Training Center', 'Conference Hall', 'Discussion Room 1', 'Discussion Room 2', 'VIP Lounge'];
        $rooms = [];
        foreach ($roomNames as $idx => $name) {
            $rooms[] = Room::create([
                'code' => 'RM-' . str_pad($idx + 1, 3, '0', STR_PAD_LEFT),
                'name' => $name,
                'capacity' => rand(5, 50),
                'facilities' => ['Proyektor', 'Whiteboard', 'AC', 'WiFi'],
                'status' => $idx === 6 ? 'maintenance' : 'aktif'
            ]);
        }

        // 4. Bookings
        $statuses = ['menunggu_approval', 'disetujui', 'ditolak', 'revisi', 'dibatalkan', 'selesai', 'kadaluarsa'];
        for ($i = 1; $i <= 30; $i++) {
            $status = $statuses[array_rand($statuses)];
            $user = $karyawans[array_rand($karyawans)];
            $room = $rooms[array_rand($rooms)];
            $date = Carbon::now()->addDays(rand(-10, 10));
            $startTime = Carbon::createFromTime(rand(8, 15), 0);
            $endTime = (clone $startTime)->addHours(rand(1, 3));
            
            Booking::create([
                'code' => 'BK-' . $date->format('Ymd') . '-' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'user_id' => $user->id,
                'room_id' => $room->id,
                'date' => $date->format('Y-m-d'),
                'start_time' => $startTime->format('H:i'),
                'end_time' => $endTime->format('H:i'),
                'purpose' => 'Meeting Internal ' . $i,
                'status' => $status,
                'approved_by' => in_array($status, ['disetujui', 'ditolak']) ? $approvers[array_rand($approvers)]->id : null,
                'approved_at' => in_array($status, ['disetujui', 'ditolak']) ? now() : null,
            ]);
        }
    }
}