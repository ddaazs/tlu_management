<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Internship;
use App\Models\Student;
use App\Models\InternshipCompany;
use App\Models\Lecturer;

class InternshipFactory extends Factory
{
    protected $model = Internship::class;

    public function definition(): array
    {
        // Lấy sinh viên có sẵn từ bảng students, không tự động tạo mới
        $student = Student::inRandomOrder()->first();
        if (!$student) {
            throw new \Exception("Không có dữ liệu trong bảng students. Hãy seed dữ liệu trước.");
        }

        // Lấy công ty từ bảng internship_companies, không tự động tạo mới
        $company = InternshipCompany::inRandomOrder()->first();
        if (!$company) {
            throw new \Exception("Không có dữ liệu trong bảng internship_companies. Hãy seed dữ liệu trước.");
        }

        // Lấy giảng viên, nếu chưa có thì tạo mới
        $instructor = Lecturer::inRandomOrder()->first() ?? Lecturer::factory()->create();

        // Đảm bảo ngày bắt đầu và kết thúc hợp lệ
        $startDate = $this->faker->date();
        $endDate = date('Y-m-d', strtotime($startDate . ' +3 months'));

        return [
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'student_id' => $student->id, // Lấy từ bảng students có sẵn
            'company_id' => $company->id, // Lấy từ bảng internship_companies có sẵn
            'instructor_id' => $instructor->id,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'status' => $this->faker->randomElement(['Chưa bắt đầu', 'Đang thực tập', 'Hoàn thành']),
            'report_file' => null,
        ];
    }
}
