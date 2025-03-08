<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $faker = \Faker\Factory::create('vi_VN'); // Dùng tiếng Việt

        // Tạo User trước để lấy thông tin
        $user = User::factory()->create(['role' => 'sinhvien']);

        return [
            'account_id' => $user->id, // ID của user
            'full_name' => $user->name, // Dùng đúng tên từ bảng users
            'email' => $user->email, // Email cũng lấy từ user (đã có dạng id@tlu.edu.vn)
            'phone_number' => $faker->numerify('09########'), // Số điện thoại VN
            'date_of_birth' => $faker->date('Y-m-d', '-18 years'), // Tuổi >= 18
            'gender' => $faker->randomElement(['Nam', 'Nữ']),
            'class' => 'Lớp ' . $faker->randomNumber(2, true),
            'major' => $faker->randomElement(['CNTT', 'Kinh tế', 'Xây dựng', 'Cơ khí']),
        ];
    }
}