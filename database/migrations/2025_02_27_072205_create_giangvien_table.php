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
        Schema::create('GiangVien', function (Blueprint $table) {
            $table->id();
            $table->string('Hoten');
            $table->foreignId('ID_BoMon')->constrained('bomon');
            $table->string('Hamvi')->nullable();
            $table->foreignID('ID_TK')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('GiangVien');
    }
};
