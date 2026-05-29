<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('maintenance_requests', function (Blueprint $table) {
            $table->id();

            // Relasi ke User (Pelapor)
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            // Relasi ke Booking (Format KOS-xxxxx)
            $table->string('booking_id', 50);
            $table->foreign('booking_id')->references('id')->on('bookings')->onDelete('cascade');

            // Data Keluhan
            $table->string('issue_name', 255);
            $table->text('description');
            $table->string('photo', 255)->nullable();
            $table->string('location', 100);

            // Status dan Pegawai
            $table->enum('status', ['pending', 'on_progress', 'done'])->default('pending');
            $table->foreignId('employee_id')->nullable()->constrained('users')->onDelete('set null');

            // Waktu laporan dibuat
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('maintenance_requests');
    }
};
