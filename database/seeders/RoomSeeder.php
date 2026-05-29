<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Room;
use App\Models\RoomType;

class RoomSeeder extends Seeder
{
    public function run(): void
    {
        // $types = RoomType::all();

        // if ($types->isEmpty()) {
        //     $this->command->info("Tipe kamar kosong, jalankan RoomTypeSeeder dulu.");
        //     return;
        // }

        // foreach ($types as $type) {
        //     for ($i = 1; $i <= 5; $i++) {

        //         $gender = ($i % 2 == 0) ? 'Putri' : 'Putra';

        //         Room::create([
        //             'room_type_id'         => $type->id,
        //             'room_number'          => strtoupper(substr($type->name, 0, 1)) . '0' . $i,
        //             'gender_type'          => $gender,
        //             'price'                => $type->base_price_monthly,
        //             'rating'               => rand(40, 50) / 10,

        //             'facilities'           => $type->facilities,

        //             'area_size'            => ($type->name == 'Luas') ? '4x5 m' : '3x4 m',
        //             'is_electric_included' => ($type->name == 'Hemat') ? false : true,
        //             'is_water_included'    => true,

        //             'room_rules'           => "1. Dilarang membawa lawan jenis ke dalam kamar.
        //             \n2. Maksimal bertamu jam 22.00 WIB.
        //             \n3. Menjaga kebersihan dan ketenangan.",
        //             'status'               => 'available',
        //         ]);
        //     }
        // }
    }
}
