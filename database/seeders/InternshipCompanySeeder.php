<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\InternshipCompany;

class InternshipCompanySeeder extends Seeder
{
    public function run(): void
    {
        InternshipCompany::factory()->count(10)->create();
    }
}