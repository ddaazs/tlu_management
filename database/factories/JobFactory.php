<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Job;

class JobFactory extends Factory
{
    protected $model = Job::class;

    public function definition(): array
    {
        return [
            'queue' => $this->faker->word,
            'payload' => json_encode(['task' => $this->faker->sentence]),
            'attempts' => $this->faker->numberBetween(1, 5),
            'reserved_at' => now()->timestamp,
            'available_at' => now()->timestamp,
            'created_at' => now()->timestamp,
        ];
    }
}
