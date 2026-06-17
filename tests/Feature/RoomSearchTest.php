<?php

use App\Models\Room;
use App\Models\RoomType;

beforeEach(function () {
    $this->typeHemat = RoomType::create([
        'name' => 'Hemat Murah',
        'description' => 'Kamar sederhana tapi nyaman',
        'facilities' => 'WiFi, Kipas',
        'base_price_daily' => 50000,
        'base_price_weekly' => 300000,
        'base_price_monthly' => 800000,
    ]);

    $this->typeSantai = RoomType::create([
        'name' => 'Santai Mewah',
        'description' => 'Kamar lengkap dengan AC dan kamar mandi dalam',
        'facilities' => 'WiFi, AC, Kamar Mandi Dalam',
        'base_price_daily' => 75000,
        'base_price_weekly' => 450000,
        'base_price_monthly' => 1200000,
    ]);

    $this->room1 = Room::create([
        'room_type_id' => $this->typeHemat->id,
        'room_number' => 'H101',
        'gender_type' => 'Putra',
        'price' => 800000,
        'status' => 'available',
        'facilities' => 'Kasur, Bantal',
        'area_size' => '3x3 m',
        'room_rules' => 'Dilarang membawa hewan peliharaan',
    ]);

    $this->room2 = Room::create([
        'room_type_id' => $this->typeSantai->id,
        'room_number' => 'S102',
        'gender_type' => 'Putri',
        'price' => 1200000,
        'status' => 'available',
        'facilities' => 'Kasur, Lemari, Meja',
        'area_size' => '4x4 m',
        'room_rules' => 'Maksimal bertamu jam 22.00',
    ]);
});

test('can search room by room number', function () {
    $response = $this->get(route('home', ['search' => 'H101']))
        ->assertStatus(200);

    $response->assertViewHas('rooms', function ($rooms) {
        return $rooms->contains('id', $this->room1->id) && ! $rooms->contains('id', $this->room2->id);
    });
});

test('can search room by room facilities', function () {
    $response = $this->get(route('home', ['search' => 'Meja']))
        ->assertStatus(200);

    $response->assertViewHas('rooms', function ($rooms) {
        return ! $rooms->contains('id', $this->room1->id) && $rooms->contains('id', $this->room2->id);
    });
});

test('can search room by room type name', function () {
    $response = $this->get(route('home', ['search' => 'Santai']))
        ->assertStatus(200);

    $response->assertViewHas('rooms', function ($rooms) {
        return ! $rooms->contains('id', $this->room1->id) && $rooms->contains('id', $this->room2->id);
    });
});

test('can search room by room type description', function () {
    $response = $this->get(route('home', ['search' => 'sederhana']))
        ->assertStatus(200);

    $response->assertViewHas('rooms', function ($rooms) {
        return $rooms->contains('id', $this->room1->id) && ! $rooms->contains('id', $this->room2->id);
    });
});

test('can search room by room type facilities', function () {
    $response = $this->get(route('home', ['search' => 'AC']))
        ->assertStatus(200);

    $response->assertViewHas('rooms', function ($rooms) {
        return ! $rooms->contains('id', $this->room1->id) && $rooms->contains('id', $this->room2->id);
    });
});

test('can search room by gender type', function () {
    $response = $this->get(route('home', ['search' => 'Putri']))
        ->assertStatus(200);

    $response->assertViewHas('rooms', function ($rooms) {
        return ! $rooms->contains('id', $this->room1->id) && $rooms->contains('id', $this->room2->id);
    });
});

test('can search room by area size', function () {
    $response = $this->get(route('home', ['search' => '3x3']))
        ->assertStatus(200);

    $response->assertViewHas('rooms', function ($rooms) {
        return $rooms->contains('id', $this->room1->id) && ! $rooms->contains('id', $this->room2->id);
    });
});

test('can search room by room rules', function () {
    $response = $this->get(route('home', ['search' => 'hewan']))
        ->assertStatus(200);

    $response->assertViewHas('rooms', function ($rooms) {
        return $rooms->contains('id', $this->room1->id) && ! $rooms->contains('id', $this->room2->id);
    });
});

test('can search room by price in room', function () {
    $response = $this->get(route('home', ['search' => '800000']))
        ->assertStatus(200);

    $response->assertViewHas('rooms', function ($rooms) {
        return $rooms->contains('id', $this->room1->id) && ! $rooms->contains('id', $this->room2->id);
    });
});

test('can search room by daily/weekly/monthly prices in room type', function () {
    // Search by base_price_daily of Santai Mewah (75000)
    $response = $this->get(route('home', ['search' => '75000']))
        ->assertStatus(200);

    $response->assertViewHas('rooms', function ($rooms) {
        return ! $rooms->contains('id', $this->room1->id) && $rooms->contains('id', $this->room2->id);
    });
});

test('can search case-insensitively', function () {
    // Search using UPPERCASE "SANTAI MEWAH"
    $response = $this->get(route('home', ['search' => 'SANTAI MEWAH']))
        ->assertStatus(200);

    $response->assertViewHas('rooms', function ($rooms) {
        return ! $rooms->contains('id', $this->room1->id) && $rooms->contains('id', $this->room2->id);
    });
});

test('can filter by numeric category ID', function () {
    $response = $this->get(route('home', ['category' => $this->typeHemat->id]))
        ->assertStatus(200);

    $response->assertViewHas('rooms', function ($rooms) {
        return $rooms->contains('id', $this->room1->id) && ! $rooms->contains('id', $this->room2->id);
    });
});

test('can filter by category name string case-insensitively', function () {
    $response = $this->get(route('home', ['category' => 'SANTAI MEWAH']))
        ->assertStatus(200);

    $response->assertViewHas('rooms', function ($rooms) {
        return ! $rooms->contains('id', $this->room1->id) && $rooms->contains('id', $this->room2->id);
    });
});

test('combines category filter and search with AND logic', function () {
    // Search matches "Kasur" (both rooms), but category filters to "Hemat Murah"
    $response = $this->get(route('home', [
        'category' => 'Hemat Murah',
        'search' => 'Kasur',
    ]))->assertStatus(200);

    $response->assertViewHas('rooms', function ($rooms) {
        return $rooms->contains('id', $this->room1->id) && ! $rooms->contains('id', $this->room2->id);
    });
});
