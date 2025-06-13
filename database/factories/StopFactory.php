<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Stop>
 */
class StopFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'address' => $this->faker->address,
            'lat' => $this->faker->latitude($min = -90, $max = 90),
            'long' => $this->faker->longitude($min = -180, $max = 180),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
