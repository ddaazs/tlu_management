<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Project;
use App\Models\DefenseSchedule;

class DefenseScheduleFactory extends Factory
{
    protected $model = DefenseSchedule::class;

    public function definition(): array
    {
        // Lấy project ngẫu nhiên, nếu chưa có thì tạo mới
        $project = Project::inRandomOrder()->first() ?? Project::factory()->create();

        return [
            'project_id' => $project->id, // Luôn lấy từ bảng projects
            'council_id' => rand(1, 10), // Tạo số ngẫu nhiên từ 1 đến 10 làm ID giả định
            'defense_date' => $this->faker->dateTimeBetween('+1 week', '+1 month'),
            'location' => $this->faker->address,
        ];
    }
}
