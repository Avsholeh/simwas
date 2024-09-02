<?php

namespace Database\Seeders;

use App\Models\TimPosisi;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Developer',
            'email' => 'developer@mail.com',
            'password' => Hash::make('developer'),
            'is_developer' => 1,
        ]);

        Auth::login(User::factory()->create([
            'name' => 'Admin Inspektorat',
            'email' => 'admin@mail.com',
            'password' => Hash::make('admin'),
        ]));

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

        Auth::logout();
    }
}
