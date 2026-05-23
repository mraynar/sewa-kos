<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_type_id')->constrained('room_types')->onDelete('cascade');
            $table->string('room_number');
            $table->enum('gender_type', ['Putra', 'Putri']);
            $table->integer('price');
            $table->decimal('rating', 2, 1)->default(0.0);
            $table->text('facilities'); 
            $table->string('area_size');
            $table->boolean('is_electric_included')->default(false);
            $table->boolean('is_water_included')->default(true);
            $table->text('room_rules');
            $table->enum('status', ['available', 'occupied', 'maintenance'])->default('available');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
