<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\DefenseSchedule;
use App\Models\Project;

class DefenseScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $projects = Project::all(); // Lấy danh sách tất cả dự án

        if ($projects->isEmpty()) {
            // Nếu chưa có project nào thì tạo trước để tránh lỗi khóa ngoại
            $projects = Project::factory(5)->create();
        }

        foreach ($projects as $project) {
            DefenseSchedule::factory()->create([
                'project_id' => $project->id, // Gán đúng khóa ngoại
                'council_id' => rand(1, 10), // Tạo số ngẫu nhiên từ 1 đến 10 làm ID giả định
            ]);
        }
    }
}
