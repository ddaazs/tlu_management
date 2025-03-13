<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;
use App\Models\User;
use App\Models\Lecturer;
use App\Models\Student;
use App\Models\InternshipCompany;
use App\Models\Internship;
use App\Models\Project;
use App\Models\Job;
use App\Models\DefenseSchedule;
use App\Models\Topic;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        // 1. Seed phòng ban (Department)
        $departments = Department::factory(6)->create();

        // 2. Seed tài khoản người dùng (User)
        // Tài khoản admin
        User::factory()->create([
            'name'  => 'admin',
            'email' => 'admin@tlu.edu.vn',
            'role'  => 'quantri',
        ]);

        // Tài khoản giảng viên
        $lecturerUsers = User::factory(10)->create([
            'role' => 'giangvien',
        ]);

        // Tài khoản sinh viên
        $studentUsers = User::factory(30)->create([
            'role' => 'sinhvien',
        ]);

        // 3. Seed thông tin giảng viên (Lecturer) dựa trên tài khoản User có role lecturer
        foreach ($lecturerUsers as $user) {
            Lecturer::factory()->create([
                // Các trường khác nếu có, ví dụ: 'specialty' => $faker->word
            ]);
        }

        // 4. Seed thông tin sinh viên (Student) dựa trên tài khoản User có role student,
        // và gán ngẫu nhiên một phòng ban cho mỗi sinh viên
        foreach ($studentUsers as $user) {
            Student::factory()->create([
                // Các trường khác nếu có
            ]);
        }

        // 5. Seed các công ty thực tập (Internship Companies)
        $internshipCompanies = InternshipCompany::factory(10)->create();

        // 6. Seed các thực tập (Internships)
        // Factory của Internship cần tự động thiết lập các khóa ngoại như: student_id, company_id, instructor_id
        Internship::factory(50)->create();

        // 7. Seed các dự án (Projects)
        // Ví dụ: mỗi dự án có thể liên kết với 1 thực tập nào đó
        Project::factory(20)->create();

        // 8. Seed các công việc (Jobs)
        Job::factory(20)->create();

        // 9. Seed lịch bảo vệ (Defense Schedules)
        DefenseSchedule::factory(20)->create();

        //10. Seed các đề tài (Topics)
        Topic::factory(30)->create();
    }
}
