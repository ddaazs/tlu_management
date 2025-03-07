<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\JobBatch;

class JobBatchFactory extends Factory
{
    protected $model = JobBatch::class;

    public function definition(): array
    {
        return [
            'id' => $this->faker->uuid,
            'name' => $this->faker->word,
            'total_jobs' => $this->faker->numberBetween(1, 100),
            'pending_jobs' => $this->faker->numberBetween(0, 50),
            'failed_jobs' => $this->faker->numberBetween(0, 10),
            'failed_job_ids' => json_encode([$this->faker->randomNumber()]),
            'options' => json_encode(['retry' => 3]),
            'cancelled_at' => null,
            'created_at' => now()->timestamp,
            'finished_at' => null,
        ];
    }
}
