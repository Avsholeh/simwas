<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TemuanFiles>
 */
class TemuanFilesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'url' => fake()->file(base_path('tests/Files'), storage_path('app/public'), false),
            'keterangan' => fake()->sentence(),
        ];
    }
}
