<?php

use App\Models\AdditionalService;
use App\Models\Booking;
use App\Models\BookingService;
use App\Models\Room;
use App\Models\RoomType;
use App\Models\User;

test('unauthenticated user cannot access pegawai tasks page', function () {
    $this->get(route('pegawai.tasks.index'))
        ->assertRedirect(route('login'));
});

test('pegawai can access tasks index and see only their tasks', function () {
    $pegawai = User::factory()->create(['role' => 'pegawai']);
    $otherPegawai = User::factory()->create(['role' => 'pegawai']);
    $tenant = User::factory()->create(['role' => 'penyewa']);

    $roomType = RoomType::create([
        'name' => 'Hemat',
        'description' => 'Hemat',
        'facilities' => 'WiFi',
        'base_price_daily' => 50000,
        'base_price_weekly' => 300000,
        'base_price_monthly' => 800000,
    ]);

    $room = Room::create([
        'room_type_id' => $roomType->id,
        'room_number' => 'H01',
        'gender_type' => 'Putra',
        'price' => 800000,
        'status' => 'available',
        'facilities' => 'WiFi, Bed',
        'area_size' => '3x4 m',
        'room_rules' => 'Rules',
    ]);

    $booking = Booking::create([
        'id' => 'BKG-TEST001',
        'user_id' => $tenant->id,
        'room_id' => $room->id,
        'check_in' => now()->format('Y-m-d'),
        'check_out' => now()->addMonth()->format('Y-m-d'),
        'total_price' => 800000,
        'status' => 'paid',
    ]);

    $cateringService = AdditionalService::create([
        'service_name' => 'Catering Makanan 2x Sehari',
        'duration_type' => 'Harian',
        'service_price' => 25000,
    ]);

    $laundryService = AdditionalService::create([
        'service_name' => 'Laundry Express',
        'duration_type' => 'Mingguan',
        'service_price' => 40000,
    ]);

    // Create task for our pegawai
    $task1 = BookingService::create([
        'booking_id' => $booking->id,
        'additional_service_id' => $cateringService->id,
        'quantity' => 1,
        'price_at_purchase' => 25000,
        'employee_id' => $pegawai->id,
        'service_status' => 'pending',
    ]);

    // Create task for other pegawai
    $task2 = BookingService::create([
        'booking_id' => $booking->id,
        'additional_service_id' => $laundryService->id,
        'quantity' => 1,
        'price_at_purchase' => 40000,
        'employee_id' => $otherPegawai->id,
        'service_status' => 'pending',
    ]);

    $this->actingAs($pegawai)
        ->get(route('pegawai.tasks.index'))
        ->assertStatus(200)
        ->assertViewHas('tasks', function ($tasks) use ($task1, $task2) {
            return $tasks->contains('id', $task1->id) && ! $tasks->contains('id', $task2->id);
        });
});

test('pegawai can filter tasks by status and category', function () {
    $pegawai = User::factory()->create(['role' => 'pegawai']);
    $tenant = User::factory()->create(['role' => 'penyewa']);

    $roomType = RoomType::create([
        'name' => 'Hemat',
        'description' => 'Hemat',
        'facilities' => 'WiFi',
        'base_price_daily' => 50000,
        'base_price_weekly' => 300000,
        'base_price_monthly' => 800000,
    ]);

    $room = Room::create([
        'room_type_id' => $roomType->id,
        'room_number' => 'H01',
        'gender_type' => 'Putra',
        'price' => 800000,
        'status' => 'available',
        'facilities' => 'WiFi, Bed',
        'area_size' => '3x4 m',
        'room_rules' => 'Rules',
    ]);

    $booking = Booking::create([
        'id' => 'BKG-TEST002',
        'user_id' => $tenant->id,
        'room_id' => $room->id,
        'check_in' => now()->format('Y-m-d'),
        'check_out' => now()->addMonth()->format('Y-m-d'),
        'total_price' => 800000,
        'status' => 'paid',
    ]);

    $cateringService = AdditionalService::create([
        'service_name' => 'Catering Makanan 2x Sehari',
        'duration_type' => 'Harian',
        'service_price' => 25000,
    ]);

    $laundryService = AdditionalService::create([
        'service_name' => 'Laundry Express',
        'duration_type' => 'Mingguan',
        'service_price' => 40000,
    ]);

    $cleaningService = AdditionalService::create([
        'service_name' => 'Cleaning Service',
        'duration_type' => 'Mingguan',
        'service_price' => 40000,
    ]);

    // task 1: Catering, status: pending
    $task1 = BookingService::create([
        'booking_id' => $booking->id,
        'additional_service_id' => $cateringService->id,
        'quantity' => 1,
        'price_at_purchase' => 25000,
        'employee_id' => $pegawai->id,
        'service_status' => 'pending',
    ]);

    // task 2: Laundry, status: on_progress
    $task2 = BookingService::create([
        'booking_id' => $booking->id,
        'additional_service_id' => $laundryService->id,
        'quantity' => 1,
        'price_at_purchase' => 40000,
        'employee_id' => $pegawai->id,
        'service_status' => 'on_progress',
    ]);

    // task 3: Cleaning, status: done
    $task3 = BookingService::create([
        'booking_id' => $booking->id,
        'additional_service_id' => $cleaningService->id,
        'quantity' => 1,
        'price_at_purchase' => 40000,
        'employee_id' => $pegawai->id,
        'service_status' => 'done',
    ]);

    $response = $this->actingAs($pegawai);

    // 1. Filter status: pending
    $response->get(route('pegawai.tasks.index', ['status' => 'pending']))
        ->assertViewHas('tasks', function ($tasks) use ($task1, $task2, $task3) {
            return $tasks->contains('id', $task1->id) && ! $tasks->contains('id', $task2->id) && ! $tasks->contains('id', $task3->id);
        });

    // 2. Filter status: on_progress
    $response->get(route('pegawai.tasks.index', ['status' => 'on_progress']))
        ->assertViewHas('tasks', function ($tasks) use ($task1, $task2, $task3) {
            return ! $tasks->contains('id', $task1->id) && $tasks->contains('id', $task2->id) && ! $tasks->contains('id', $task3->id);
        });

    // 3. Filter category: Laundry
    $response->get(route('pegawai.tasks.index', ['category' => 'Laundry']))
        ->assertViewHas('tasks', function ($tasks) use ($task1, $task2, $task3) {
            return ! $tasks->contains('id', $task1->id) && $tasks->contains('id', $task2->id) && ! $tasks->contains('id', $task3->id);
        });

    // 4. Filter status: done & category: Cleaning
    $response->get(route('pegawai.tasks.index', ['status' => 'done', 'category' => 'Cleaning']))
        ->assertViewHas('tasks', function ($tasks) use ($task1, $task2, $task3) {
            return ! $tasks->contains('id', $task1->id) && ! $tasks->contains('id', $task2->id) && $tasks->contains('id', $task3->id);
        });
});
