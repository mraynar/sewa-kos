<?php

namespace Database\Seeders;

use App\Models\AdditionalService;
use Illuminate\Database\Seeder;

class AdditionalServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AdditionalService::create([
            'service_name' => 'Catering Makanan 2x Sehari',
            'duration_type' => 'Harian',
            'service_price' => 25000,
        ]);

        AdditionalService::create([
            'service_name' => 'Laundry Express',
            'duration_type' => 'Mingguan',
            'service_price' => 40000,
        ]);

        AdditionalService::create([
            'service_name' => 'Cleaning Service',
            'duration_type' => 'Mingguan',
            'service_price' => 40000,
        ]);
    }
}
