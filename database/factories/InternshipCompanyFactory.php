<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\InternshipCompany;

class InternshipCompanyFactory extends Factory
{
    protected $model = InternshipCompany::class;

    
    public function definition(): array
    {
        return [
            'company_name' => $this->faker->company,
            'address' => $this->faker->address,
            'email' => $this->faker->unique()->companyEmail,
            'phone_number' => $this->faker->phoneNumber,
            'field'          => $this->faker->randomElement([
                'Công nghệ thông tin', 
                'Kinh tế', 
                'Cơ khí', 
                'Xây dựng', 
                'Điện tử - Viễn thông',
                'Môi trường'
            ]),
        ];
    }
}