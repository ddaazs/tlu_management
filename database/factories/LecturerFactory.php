<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Lecturer;
use App\Models\Department;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Lecturer>
 */
class LecturerFactory extends Factory
{
    protected $model = Lecturer::class;

    public function definition(): array
    {
        $faker = \Faker\Factory::create('vi_VN'); // Dùng tiếng Việt

        // Lấy user có role = 'giangvien' từ bảng users
        $user = User::where('role', 'giangvien')->inRandomOrder()->first();

        // Nếu không có user nào -> tạo mới 1 user giảng viên
        if (!$user) {
            $user = User::factory()->create([
                'role' => 'giangvien'
            ]);
        }
         // Random tên khoa
    $departmentName = $faker->randomElement(['CNTT', 'Kinh tế', 'Cơ khí', 'Xây dựng']);
    $department = Department::where('name', $departmentName)->first();
    if (!$department) {
        $department = Department::create(['name' => $departmentName]);
    }

    // Tạo email từ tên user
    $email = Str::slug($user->name, '') . '@tlu.edu.vn';

    // Nếu email đã tồn tại trong lecturers -> thêm số ngẫu nhiên vào
    while (Lecturer::where('email', $email)->exists()) {
        $email = Str::slug($user->name, '') . rand(100, 999) . '@tlu.edu.vn';
    }

        return [
            'account_id' => $user->id, // Lấy ID từ user
            'full_name' => $user->name, // Lấy tên từ user
            'email' => Str::slug($user->name, '') . '@tlu.edu.vn', // Bỏ dấu trong email
            'phone_number' => $faker->numerify('09########'), // Số điện thoại
            'degree' => $faker->randomElement(['Thạc sĩ', 'Tiến sĩ', 'Phó Giáo sư', 'Giáo sư']),
            'department_id' => $department->id, // Lấy ID từ khoa
        ];
    }
}