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

        User::create([
            'name' => 'hammam',
            'nickname' => 'hammam',
            'full_name_ktp' => 'Muhammad Raynar Hammam',
            'email' => 'hammam@gmail.com',
            'password' => Hash::make('password'),
            'phone' => '08953023232',
            'address' => 'Manukan Luhur',
            'gender' => 'Laki-laki',
            'birth_date' => '2006-05-23',
            'role' => 'penyewa',
            'is_verified' => 'verified',
        ]);

        $this->call([
            RoomTypeSeeder::class,
            RoomSeeder::class,
            AdditionalServiceSeeder::class,
        ]);
    }
}
