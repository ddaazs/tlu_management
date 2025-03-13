<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $faker = \Faker\Factory::create('vi_VN'); // Faker tiếng Việt

        // Chọn ngẫu nhiên vai trò
        $role = $faker->randomElement(['giangvien', 'sinhvien', 'quantri']);

        // Sinh tên đầy đủ
        $name = $faker->name();
        $nameWithoutSpaces = str_replace(' ', '', $name);
        // Xử lý email theo vai trò
        if ($role === 'sinhvien') {
            $email = $faker->unique()->numerify('######') . '@tlu.edu.vn'; // Dạng id@tlu.edu.vn
        } else { // Giảng viên hoặc quản trị
            $slug_name = Str::slug($name, ''); // Bỏ dấu và ghép liền tên
            $email = strtolower($slug_name) . '@tlu.edu.vn'; // Đưa về chữ thường
        }

        return [
            'name' => $name,
            'email' => $email,
            'email_verified_at' => now(),
            'password' => Hash::make('password'), // Mật khẩu mặc định
            'role' => $role,
            'status' => $faker->randomElement(['active', 'inactive', 'banned']),
            'remember_token' => Str::random(10),
        ];
    }
}
