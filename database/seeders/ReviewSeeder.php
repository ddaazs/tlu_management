<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Project;
use App\Models\Review;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Lấy tất cả các dự án có status 'Hoàn thành'
        $completedProjects = Project::where('status', 'Hoàn thành')->get();

        foreach ($completedProjects as $project) {
            // Tạo review cho dự án, sử dụng instructor_id của project và random score từ 5 đến 9
            Review::create([
                'project_id'  => $project->id,
                'lecturer_id' => $project->instructor_id,
                'score'       => rand(5, 9), // random số nguyên từ 5 đến 9
            ]);
        }
    }
}
