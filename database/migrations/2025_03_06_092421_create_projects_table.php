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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('instructor_id');
            $table->unsignedBigInteger('topic_id')->nullable(); // Đảm bảo kiểu dữ liệu khớp với bảng topics
            $table->string('status');
            $table->string('project_file')->nullable();
            $table->foreign('student_id')->references('id')->on('students');
            $table->foreign('instructor_id')->references('id')->on('lecturers');
            $table->timestamps();

            // Khóa ngoại
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            $table->foreign('instructor_id')->references('id')->on('lecturers')->onDelete('cascade');
            $table->foreign('topic_id')->references('id')->on('topics')->onDelete('cascade'); // Đảm bảo bảng topics tồn tại trước khi chạy
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
