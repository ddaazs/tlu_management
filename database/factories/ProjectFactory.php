<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Project;
use App\Models\Student;
use App\Models\Lecturer;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    protected $model = Project::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence(3), // Đặt tên dự án
            'description' => $this->faker->paragraph(), // Mô tả
            'student_id' => Student::inRandomOrder()->first()->id ?? Student::factory()->create()->id,
            'instructor_id' => Lecturer::inRandomOrder()->first()->id ?? Lecturer::factory()->create()->id,
            'status' => $this->faker->randomElement(['Đang thực hiện', 'Hoàn thành', 'Hủy bỏ']),
        ];
    }
}
