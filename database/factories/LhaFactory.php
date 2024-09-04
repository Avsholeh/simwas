<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Lha>
 */
class LhaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nomor' => fake()->randomNumber(1) . '/LHA/' . date('Y'),
            'tanggal' => now()->subMonth(fake()->randomElement([0, 1, 2, 3])),
            'deskripsi' => fake()->sentence(3),
            'created_at' => now()->subMonth(fake()->randomElement([0, 1, 2, 3])),
            'created_by' => \App\Models\User::factory(),
        ];
    }
}
