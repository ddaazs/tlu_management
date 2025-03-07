<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Internship;
use App\Models\Student;
use App\Models\InternshipCompany;

class InternshipFactory extends Factory
{
    protected $model = Internship::class;

    public function definition(): array
    {
        return [
            'student_id' => Student::inRandomOrder()->first()->id ?? Student::factory()->create()->id,
            'company_id' => InternshipCompany::inRandomOrder()->first()->id ?? InternshipCompany::factory()->create()->id,
            'start_date' => $this->faker->date(),
            'end_date' => $this->faker->date(),
            'status' => $this->faker->randomElement(['Chưa bắt đầu', 'Đang thực tập', 'Hoàn thành']),
        ];
    }
}
