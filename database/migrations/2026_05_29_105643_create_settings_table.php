<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            // Karena primary key-nya adalah teks (key), kita gunakan string
            $table->string('key', 100)->primary();
            $table->text('value')->nullable();

            // Opsional: Jika Anda ingin menambahkan timestamps (created_at, updated_at)
            // $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
