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
        Schema::create('DoanhNghiep', function (Blueprint $table) {
            $table->id();
            $table->string('Ten', 100);
            $table->string('Diachi', 200)->nullable();  
            $table->string('Sodienthoai', 10)->unique(); 
            $table->string('Email', 100)->nullable()->unique(); 
            $table->string('Mota', 100)->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('DoanhNghiep');
    }
};
