<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Job;
use App\Models\JobBatch;
use App\Models\FailedJob;

class JobSeeder extends Seeder
{
    public function run(): void
    {
        Job::factory()->count(10)->create();
        JobBatch::factory()->count(5)->create();
        FailedJob::factory()->count(5)->create();
    }
}
