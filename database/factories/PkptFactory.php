<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pkpt>
 */
class PkptFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama_kegiatan' => fake()->sentence,
            'objek_pengawasan' => fake()->company,
            'keterangan_pengawasan' => fake()->paragraph,
            'tingkat_risiko' => fake()->randomElement(['Rendah', 'Sedang', 'Tinggi']),
            'tujuan' => fake()->paragraph,
            'sasaran' => fake()->paragraph,
            'jumlah_hari' => fake()->numberBetween(1, 30),
            'masa_periksa' => fake()->word,
            'tanggal_mulai' => Carbon::now()->subDays(10),
            'tanggal_selesai' => Carbon::now()->addDays(10),
            'biaya' => fake()->randomFloat(2, 1000000, 10000000),
            'rencana_penyelesaian' => fake()->sentence,
            'unit_pelaksana' => fake()->company,
            'sarana_penunjang' => fake()->sentence,
            'tahun_pelaksanaan' => Carbon::now()->year,
            'inspektur_id' => \App\Models\User::factory(),
            'dasar_surat' => fake()->sentence,
            'created_by' => \App\Models\User::factory(),
            'updated_by' => null,
            'deleted_by' => null,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'deleted_at' => null,
        ];
    }
}
