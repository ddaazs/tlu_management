<?php

namespace Database\Factories;

use App\Models\Topic;
use App\Models\Lecturer;
use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Topic>
 */
class TopicFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Topic::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(6), // Tạo tiêu đề ngẫu nhiên
            'description' => $this->faker->paragraph(3), // Mô tả đề tài
            'student_id' => rand(0, 1) ? Student::inRandomOrder()->first()->id : null, // Chọn ngẫu nhiên 1 sinh viên hoặc null
            'lecturer_id' => Lecturer::inRandomOrder()->value('id') ?? 1, // Chọn ngẫu nhiên 1 giảng viên, mặc định là 1 nếu không có
            'status' => $this->faker->randomElement(['pending', 'approved', 'rejected']), // Trạng thái ngẫu nhiên
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
