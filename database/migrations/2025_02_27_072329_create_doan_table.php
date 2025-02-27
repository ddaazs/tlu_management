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
        Schema::create('DoAn', function (Blueprint $table) {
            $table->id();
            $table->string('Ten', 100);
            $table->foreignId('ID_SV')->constrained('sinhvien');
            $table->foreignId('ID_GV')->constrained('giangvien');
            $table->string('Trangthai', 100)->default('Chưa hoàn thành');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('DoAn');
    }
};
