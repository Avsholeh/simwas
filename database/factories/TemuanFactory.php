<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Temuan>
 */
class TemuanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'lha_id' => \App\Models\Lha::factory(),
            'tahun_pelaksanaan' => now()->year,
            'objek_pengawasan' => fake()->company(),
            'judul' => fake()->sentence(),
            'kode' => fake()->randomNumber() . '/TM/' . now()->year,
            'kondisi' => fake()->paragraph(),
            'kriteria' => fake()->paragraph(),
            'akibat' => fake()->paragraph(),
            'rekomendasi_kode' => fake()->randomNumber() . '/TM-RK/' . now()->year,
            'rekomendasi_temuan' => fake()->paragraph(),
            'created_at' => now()->subMonth(fake()->randomElement([0, 1, 2, 3])),
            'created_by' => \App\Models\User::factory(),
        ];
    }
}
