<?php

namespace Database\Seeders;

use App\Models\TimPosisi;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'superadmin@mail.com',
            'password' => Hash::make('superadmin'),
            'is_admin' => 1,
        ]);

        TimPosisi::factory()->createMany([
            ['nama_posisi' => 'Penanggung Jawab'],
            ['nama_posisi' => 'Pembantu Penanggung Jawab'],
            ['nama_posisi' => 'Pengendali Teknis'],
            ['nama_posisi' => 'Ketua Tim'],
            ['nama_posisi' => 'Wakil Ketua Tim'],
            ['nama_posisi' => 'Anggota Tim'],
        ]);

        if (env('APP_ENV') !== 'production') {
            $this->call([
                DevelopSeeder::class,
            ]);
        }
    }
}
