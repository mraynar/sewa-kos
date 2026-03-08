<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {

        User::create([
            'name' => 'Admin Kos',
            'nickname' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '08123456781',
        ]);

        User::create([
            'name' => 'Pegawai User',
            'nickname' => 'pegawai',
            'email' => 'pegawai@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'pegawai',
            'phone' => '08123456782',
        ]);

        User::create([
            'name' => 'Penyewa User',
            'nickname' => 'penyewa',
            'email' => 'penyewa@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'penyewa',
            'phone' => '08123456783',
        ]);

        $this->call([
            RoomTypeSeeder::class,
            RoomSeeder::class,
            AdditionalServiceSeeder::class,
        ]);
    }
}
