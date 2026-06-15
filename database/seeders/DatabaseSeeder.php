<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $now = Carbon::now();

        // 1. Matikan pengecekan Foreign Key sementara agar aman saat Truncate
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Bersihkan tabel sebelum di-seed (DITAMBAHKAN maintenance_requests)
        DB::table('maintenance_requests')->truncate();
        DB::table('booking_service')->truncate();
        DB::table('bookings')->truncate();
        DB::table('additional_services')->truncate();
        DB::table('rooms')->truncate();
        DB::table('room_types')->truncate();
        DB::table('users')->truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 2. SEED USERS (Sesuai SQL Dump)
        DB::table('users')->insert([
            [
                'id' => 1,
                'name' => 'Admin Kos',
                'nickname' => 'admin',
                'full_name_ktp' => null,
                'email' => 'admin@gmail.com',
                'phone' => '08123456781',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'is_verified' => null,
                'gender' => null,
                'birth_date' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 2,
                'name' => 'Pegawai User',
                'nickname' => 'pegawai',
                'full_name_ktp' => null,
                'email' => 'pegawai@gmail.com',
                'phone' => '08123456782',
                'password' => Hash::make('password'),
                'role' => 'pegawai',
                'is_verified' => null,
                'gender' => null,
                'birth_date' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 3,
                'name' => 'Penyewa User',
                'nickname' => 'penyewa',
                'full_name_ktp' => 'tes',
                'email' => 'penyewa@gmail.com',
                'phone' => '08123456783',
                'password' => Hash::make('password'),
                'role' => 'penyewa',
                'is_verified' => 'verified',
                'gender' => 'Perempuan',
                'birth_date' => '2011-05-03',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 4,
                'name' => 'hammam',
                'nickname' => 'hammam',
                'full_name_ktp' => 'Muhammad Raynar Hammam',
                'email' => 'hammam@gmail.com',
                'phone' => '08953023232',
                'password' => Hash::make('password'),
                'role' => 'penyewa',
                'is_verified' => 'verified',
                'gender' => 'Laki-laki',
                'birth_date' => '2006-05-23',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);

        // 3. SEED ROOM TYPES
        $roomTypes = [
            ['id' => 1, 'name' => 'Hemat', 'image' => 'kamar-hemat.jpg', 'description' => 'Kamar sederhana dan nyaman untuk mahasiswa dengan harga terjangkau.', 'facilities' => '"Bed, Lemari, Meja Belajar, Kipas Angin, WiFi"', 'base_price_daily' => 50000, 'base_price_weekly' => 300000, 'base_price_monthly' => 800000],
            ['id' => 2, 'name' => 'Santai', 'image' => 'kamar-santai.jpg', 'description' => 'Kamar dengan fasilitas lebih lengkap dan kamar mandi dalam.', 'facilities' => '"Bed, Lemari, Meja Belajar, AC, Kamar Mandi Dalam, WiFi"', 'base_price_daily' => 75000, 'base_price_weekly' => 450000, 'base_price_monthly' => 1200000],
            ['id' => 3, 'name' => 'Nyaman', 'image' => 'kamar-nyaman.jpg', 'description' => 'Kamar luas cocok untuk mahasiswa tingkat akhir atau pekerja remote.', 'facilities' => '"Bed Queen, Lemari Besar, Meja Kerja, AC, Kamar Mandi Dalam, WiFi"', 'base_price_daily' => 100000, 'base_price_weekly' => 600000, 'base_price_monthly' => 1500000],
            ['id' => 4, 'name' => 'Luas', 'image' => 'kamar-luas.jpg', 'description' => 'Kamar paling lega dengan fasilitas lengkap dan nyaman untuk jangka panjang.', 'facilities' => '"Bed Queen, Lemari Besar, Meja Kerja, AC, Kamar Mandi Dalam, TV, WiFi"', 'base_price_daily' => 150000, 'base_price_weekly' => 900000, 'base_price_monthly' => 2000000],
        ];

        foreach ($roomTypes as &$type) {
            $type['created_at'] = $now;
            $type['updated_at'] = $now;
        }
        DB::table('room_types')->insert($roomTypes);

        // 4. SEED ROOMS
        $rooms = [];
        $rules = "1. Dilarang membawa lawan jenis ke dalam kamar.\n2. Maksimal bertamu jam 22.00 WIB.\n3. Menjaga kebersihan dan ketenangan.";

        for ($i = 1; $i <= 5; $i++) {
            $rooms[] = ['room_type_id' => 1, 'room_number' => 'H0'.$i, 'gender_type' => $i % 2 == 0 ? 'Putri' : 'Putra', 'price' => 800000, 'rating' => $faker->randomFloat(1, 4.0, 5.0), 'facilities' => '"Bed, Lemari, Meja Belajar, Kipas Angin, WiFi"', 'area_size' => '3x4 m', 'is_electric_included' => 0, 'is_water_included' => 1, 'room_rules' => $rules, 'status' => 'available', 'created_at' => $now, 'updated_at' => $now];
        }
        for ($i = 1; $i <= 5; $i++) {
            $rooms[] = ['room_type_id' => 2, 'room_number' => 'S0'.$i, 'gender_type' => $i % 2 == 0 ? 'Putri' : 'Putra', 'price' => 1200000, 'rating' => $faker->randomFloat(1, 4.0, 5.0), 'facilities' => '"Bed, Lemari, Meja Belajar, AC, Kamar Mandi Dalam, WiFi"', 'area_size' => '3x4 m', 'is_electric_included' => 1, 'is_water_included' => 1, 'room_rules' => $rules, 'status' => 'available', 'created_at' => $now, 'updated_at' => $now];
        }
        for ($i = 1; $i <= 5; $i++) {
            $rooms[] = ['room_type_id' => 3, 'room_number' => 'N0'.$i, 'gender_type' => $i % 2 == 0 ? 'Putri' : 'Putra', 'price' => 1500000, 'rating' => $faker->randomFloat(1, 4.0, 5.0), 'facilities' => '"Bed Queen, Lemari Besar, Meja Kerja, AC, Kamar Mandi Dalam, WiFi"', 'area_size' => '3x4 m', 'is_electric_included' => 1, 'is_water_included' => 1, 'room_rules' => $rules, 'status' => 'available', 'created_at' => $now, 'updated_at' => $now];
        }
        for ($i = 1; $i <= 5; $i++) {
            $rooms[] = ['room_type_id' => 4, 'room_number' => 'L0'.$i, 'gender_type' => $i % 2 == 0 ? 'Putri' : 'Putra', 'price' => 2000000, 'rating' => $faker->randomFloat(1, 4.0, 5.0), 'facilities' => '"Bed Queen, Lemari Besar, Meja Kerja, AC, Kamar Mandi Dalam, TV, WiFi"', 'area_size' => '4x5 m', 'is_electric_included' => 1, 'is_water_included' => 1, 'room_rules' => $rules, 'status' => 'available', 'created_at' => $now, 'updated_at' => $now];
        }
        DB::table('rooms')->insert($rooms);

        // 5. SEED ADDITIONAL SERVICES
        DB::table('additional_services')->insert([
            ['id' => 1, 'service_name' => 'Catering Makanan 2x Sehari', 'duration_type' => 'Harian', 'service_price' => 25000, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 2, 'service_name' => 'Laundry Express', 'duration_type' => 'Mingguan', 'service_price' => 40000, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 3, 'service_name' => 'Cleaning Service', 'duration_type' => 'Mingguan', 'service_price' => 40000, 'created_at' => $now, 'updated_at' => $now],
        ]);

        // 6. GENERATE DUMMY BOOKINGS & BOOKING SERVICES
        $statuses = ['pending', 'paid', 'expired', 'canceled'];
        $tenantIds = [3, 4];

        for ($i = 1; $i <= 10; $i++) {
            $roomId = $faker->numberBetween(1, 20);
            $roomPrice = DB::table('rooms')->where('id', $roomId)->value('price');
            $status = $faker->randomElement($statuses);

            $checkIn = Carbon::parse($faker->dateTimeBetween('-1 month', '+1 month'));
            // Menggunakan copy() agar $checkIn tidak berubah nilainya
            $checkOut = $checkIn->copy()->addMonths($faker->numberBetween(1, 12));

            $bookingId = 'BKG-'.strtoupper(Str::random(10));

            DB::table('bookings')->insert([
                'id' => $bookingId,
                'user_id' => $faker->randomElement($tenantIds),
                'room_id' => $roomId,
                'check_in' => $checkIn->format('Y-m-d'),
                'check_out' => $checkOut->format('Y-m-d'),
                'total_price' => $roomPrice * $checkIn->diffInMonths($checkOut),
                'status' => $status,
                'payment_token' => $status == 'pending' ? Str::random(20) : null,
                // Menggunakan copy()
                'created_at' => $checkIn->copy()->subDays($faker->numberBetween(1, 5)),
                'updated_at' => $now,
            ]);

            if ($status == 'paid') {
                DB::table('rooms')->where('id', $roomId)->update(['status' => 'occupied']);
            }

            $serviceCount = $faker->numberBetween(0, 2);
            for ($s = 1; $s <= $serviceCount; $s++) {
                $serviceId = $faker->numberBetween(1, 3);
                $servicePrice = DB::table('additional_services')->where('id', $serviceId)->value('service_price');
                $quantity = $faker->numberBetween(1, 5);

                DB::table('booking_service')->insert([
                    'booking_id' => $bookingId,
                    'additional_service_id' => $serviceId,
                    'quantity' => $quantity,
                    'price_at_purchase' => $servicePrice,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);

                DB::table('bookings')->where('id', $bookingId)->increment('total_price', ($servicePrice * $quantity));
            }
        }

        // 7. GENERATE MAINTENANCE REQUESTS
        $randomBookings = DB::table('bookings')->inRandomOrder()->limit(3)->pluck('id');

        if ($randomBookings->count() >= 3) {
            DB::table('maintenance_requests')->insert([
                [
                    'user_id' => 4,
                    'booking_id' => $randomBookings[0],
                    'issue_name' => 'Shower tidak menyala',
                    'description' => 'Air di shower tidak keluar',
                    'photo' => 'MAINT_1775401488_4.jpg',
                    'location' => 'Kamar S01',
                    'status' => 'done',
                    'employee_id' => 2,
                    // Diubah menjadi now() helper agar tidak ada mutasi referensi waktu
                    'created_at' => now()->subDays(2),
                ],
                [
                    'user_id' => 4,
                    'booking_id' => $randomBookings[1],
                    'issue_name' => 'AC Tidak Dingin',
                    'description' => 'AC mengalami kebocoran',
                    'photo' => 'ISSUE_1775401547_8.jpg',
                    'location' => 'Kamar L01',
                    'status' => 'on_progress',
                    'employee_id' => 2,
                    'created_at' => now()->subHours(5),
                ],
                [
                    'user_id' => 4,
                    'booking_id' => $randomBookings[2],
                    'issue_name' => 'TV tidak bisa menyala',
                    'description' => 'TV Rusak tidak dapat terhubung dengan internet',
                    'photo' => 'MAINT_1775402006_6.jpg',
                    'location' => 'Kamar L02',
                    'status' => 'pending',
                    'employee_id' => null,
                    'created_at' => now()->subMinutes(30),
                ],
            ]);
        }
    }
}
