<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('booking_service', function (Blueprint $table) {
            $table->id();

            // Relasi ke tabel bookings (tipe string karena format Anda KOS-xxxxx)
            $table->string('booking_id', 50);
            $table->foreign('booking_id')->references('id')->on('bookings')->onDelete('cascade');

            // Relasi ke tabel additional_services
            $table->foreignId('additional_service_id')->constrained('additional_services')->onDelete('cascade');

            $table->integer('quantity');
            $table->integer('price_at_purchase');

            // DUA KOLOM INI YANG SEBELUMNYA HILANG:
            $table->enum('service_status', ['pending', 'on_progress', 'done'])->default('pending');
            $table->foreignId('employee_id')->nullable()->constrained('users')->onDelete('set null');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('booking_service');
    }
};
