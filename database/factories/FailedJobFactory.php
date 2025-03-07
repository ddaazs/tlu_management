<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\FailedJob;

class FailedJobFactory extends Factory
{
    protected $model = FailedJob::class;

    public function definition(): array
    {
        return [
            'uuid' => $this->faker->uuid,
            'connection' => 'database',
            'queue' => $this->faker->word,
            'payload' => json_encode(['task' => $this->faker->sentence]),
            'exception' => $this->faker->text(200),
            'failed_at' => now(),
        ];
    }
}
