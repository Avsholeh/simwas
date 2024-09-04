<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Kka>
 */
class KkaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'judul' => fake()->sentence(),
            'keterangan' => fake()->paragraph(),
            'created_at' => now()->subMonth(fake()->randomElement([0, 1, 2, 3])),
            'created_by' => \App\Models\User::factory(),
        ];
    }
}
