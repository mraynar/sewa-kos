<?php

use App\Models\Booking;
use App\Models\Room;
use App\Models\RoomType;
use App\Models\User;

// ─── Helpers ────────────────────────────────────────────────────────────────

function makeRoom(): Room
{
    $roomType = RoomType::create([
        'name' => 'Standard',
        'description' => 'Standard',
        'facilities' => 'WiFi',
        'base_price_daily' => 50000,
        'base_price_weekly' => 300000,
        'base_price_monthly' => 800000,
    ]);

    return Room::create([
        'room_type_id' => $roomType->id,
        'room_number' => 'S'.fake()->unique()->numberBetween(1, 999),
        'gender_type' => 'Putra',
        'price' => 800000,
        'status' => 'available',
        'facilities' => 'WiFi, Bed',
        'area_size' => '3x4 m',
        'room_rules' => 'Rules',
    ]);
}

function makeBooking(User $user, Room $room, string $status, string $checkIn, string $checkOut): Booking
{
    return Booking::create([
        'id' => 'BKG-DST-'.fake()->unique()->numberBetween(100, 999),
        'user_id' => $user->id,
        'room_id' => $room->id,
        'check_in' => $checkIn,
        'check_out' => $checkOut,
        'total_price' => 800000,
        'status' => $status,
    ]);
}

// ─── display_status accessor ────────────────────────────────────────────────

test('display_status returns Lunas when paid and today is before check_in', function () {
    $user = User::factory()->create(['role' => 'penyewa']);
    $room = makeRoom();
    $booking = makeBooking($user, $room, 'paid',
        now()->addDay()->toDateString(),
        now()->addMonth()->toDateString()
    );

    expect($booking->display_status)->toBe('Lunas');
});

test('display_status returns Ditempati when paid and today equals check_in', function () {
    $user = User::factory()->create(['role' => 'penyewa']);
    $room = makeRoom();
    $booking = makeBooking($user, $room, 'paid',
        now()->toDateString(),
        now()->addMonth()->toDateString()
    );

    expect($booking->display_status)->toBe('Ditempati');
});

test('display_status returns Ditempati when paid and today is between check_in and check_out', function () {
    $user = User::factory()->create(['role' => 'penyewa']);
    $room = makeRoom();
    $booking = makeBooking($user, $room, 'paid',
        now()->subWeek()->toDateString(),
        now()->addWeek()->toDateString()
    );

    expect($booking->display_status)->toBe('Ditempati');
});

test('display_status returns Ditempati when paid and today equals check_out', function () {
    $user = User::factory()->create(['role' => 'penyewa']);
    $room = makeRoom();
    $booking = makeBooking($user, $room, 'paid',
        now()->subMonth()->toDateString(),
        now()->toDateString()
    );

    expect($booking->display_status)->toBe('Ditempati');
});

test('display_status returns Selesai when paid and today is after check_out', function () {
    $user = User::factory()->create(['role' => 'penyewa']);
    $room = makeRoom();
    $booking = makeBooking($user, $room, 'paid',
        now()->subMonth()->toDateString(),
        now()->subDay()->toDateString()
    );

    expect($booking->display_status)->toBe('Selesai');
});

test('display_status returns raw status for pending bookings', function () {
    $user = User::factory()->create(['role' => 'penyewa']);
    $room = makeRoom();
    $booking = makeBooking($user, $room, 'pending',
        now()->addDay()->toDateString(),
        now()->addMonth()->toDateString()
    );

    expect($booking->display_status)->toBe('pending');
});

test('display_status returns raw status for expired bookings', function () {
    $user = User::factory()->create(['role' => 'penyewa']);
    $room = makeRoom();
    $booking = makeBooking($user, $room, 'expired',
        now()->subMonth()->toDateString(),
        now()->subDay()->toDateString()
    );

    expect($booking->display_status)->toBe('expired');
});

test('display_status returns raw status for canceled bookings', function () {
    $user = User::factory()->create(['role' => 'penyewa']);
    $room = makeRoom();
    $booking = makeBooking($user, $room, 'canceled',
        now()->addDay()->toDateString(),
        now()->addMonth()->toDateString()
    );

    expect($booking->display_status)->toBe('canceled');
});

// ─── scopeCurrentlyActive ───────────────────────────────────────────────────

test('scopeCurrentlyActive only returns paid bookings within the rental period', function () {
    $user = User::factory()->create(['role' => 'penyewa']);
    $room = makeRoom();

    $activeBooking = makeBooking($user, $room, 'paid',
        now()->subDay()->toDateString(),
        now()->addDay()->toDateString()
    );

    $upcomingBooking = makeBooking($user, $room, 'paid',
        now()->addDay()->toDateString(),
        now()->addMonth()->toDateString()
    );

    $pastBooking = makeBooking($user, $room, 'paid',
        now()->subMonth()->toDateString(),
        now()->subDay()->toDateString()
    );

    $pendingBooking = makeBooking($user, $room, 'pending',
        now()->subDay()->toDateString(),
        now()->addDay()->toDateString()
    );

    $results = Booking::where('user_id', $user->id)->currentlyActive()->get();

    expect($results)->toHaveCount(1)
        ->and($results->first()->id)->toBe($activeBooking->id);
});

// ─── report controller backend guard ────────────────────────────────────────

test('report controller rejects booking that is not currently active', function () {
    $user = User::factory()->create(['role' => 'penyewa']);
    $room = makeRoom();

    // Upcoming (paid but not started yet)
    $upcomingBooking = makeBooking($user, $room, 'paid',
        now()->addDay()->toDateString(),
        now()->addMonth()->toDateString()
    );

    $response = $this->actingAs($user)->post(route('profile.report'), [
        'booking_id' => $upcomingBooking->id,
        'issue_name' => 'Test Issue',
        'description' => 'Test description',
    ]);

    $response->assertSessionHasErrors('booking_id');
});

test('report controller rejects booking belonging to another user', function () {
    $user = User::factory()->create(['role' => 'penyewa']);
    $otherUser = User::factory()->create(['role' => 'penyewa']);
    $room = makeRoom();

    $otherBooking = makeBooking($otherUser, $room, 'paid',
        now()->subDay()->toDateString(),
        now()->addDay()->toDateString()
    );

    $response = $this->actingAs($user)->post(route('profile.report'), [
        'booking_id' => $otherBooking->id,
        'issue_name' => 'Test Issue',
        'description' => 'Test description',
    ]);

    $response->assertSessionHasErrors('booking_id');
});

test('report controller accepts a valid currently active booking', function () {
    $user = User::factory()->create(['role' => 'penyewa']);
    $room = makeRoom();

    $activeBooking = makeBooking($user, $room, 'paid',
        now()->subDay()->toDateString(),
        now()->addDay()->toDateString()
    );

    $response = $this->actingAs($user)->post(route('profile.report'), [
        'booking_id' => $activeBooking->id,
        'issue_name' => 'AC tidak dingin',
        'description' => 'AC di kamar sudah 3 hari tidak dingin.',
    ]);

    $response->assertRedirect(route('profile', ['tab' => 'report']));
    $response->assertSessionHas('success');
});
