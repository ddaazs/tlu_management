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
        Schema::create('topics', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->unsignedBigInteger('student_id')->nullable(); // Sinh viên đăng ký (có thể null)
            $table->unsignedBigInteger('lecturer_id'); // Giảng viên hướng dẫn
            $table->string('status')->default('pending'); // Trạng thái: pending, approved, rejected
            $table->foreign('student_id')->references('id')->on('students')->onDelete('set null');
            $table->foreign('lecturer_id')->references('id')->on('lecturers')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('topics');
    }
};
