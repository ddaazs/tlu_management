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
        Schema::create('internships', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('instructor_id');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('status');
            $table->string('report_file')->nullable();
            $table->foreign('student_id')->references('id')->on('students');
            $table->foreign('company_id')->references('id')->on('internship_companies');
            $table->foreign('instructor_id')->references('id')->on('lecturers');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('internships');
    }
};
