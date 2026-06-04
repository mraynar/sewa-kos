<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PegawaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Budi Santoso',
            'nickname' => 'budi',
            'email' => 'budi@gmail.com',
            'phone' => '081234567821',
            'password' => Hash::make('password'),
            'role' => 'pegawai',
            'gender' => 'Laki-laki',
            'birth_date' => '1995-08-12',
            'is_verified' => 'verified',
        ]);

        User::create([
            'name' => 'Ani Wijaya',
            'nickname' => 'ani',
            'email' => 'ani@gmail.com',
            'phone' => '081234567822',
            'password' => Hash::make('password'),
            'role' => 'pegawai',
            'gender' => 'Perempuan',
            'birth_date' => '1997-04-25',
            'is_verified' => 'verified',
        ]);
    }
}
