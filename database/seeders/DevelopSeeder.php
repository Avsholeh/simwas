<?php

namespace Database\Seeders;

use App\Models\Pkpt;
use App\Models\Tim;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DevelopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::factory(3)->create();

        $tim = Tim::factory()->createMany([
            ['nama_tim' => 'Pengawasan Keuangan Daerah', 'deskripsi' => 'Tim pengawasan keuangan daerah'],
            ['nama_tim' => 'Pengawasan Pembangunan Daerah', 'deskripsi' => 'Tim pengawasan pembangunan daerah'],
            ['nama_tim' => 'Pengawasan Pemerintahan Daerah', 'deskripsi' => 'Tim pengawasan pemerintahan daerah'],
            ['nama_tim' => 'Pengawasan Pengadaan Barang dan Jasa', 'deskripsi' => 'Tim pengawasan pengadaan barang dan jasa'],
            ['nama_tim' => 'Pengawasan Pelayanan Publik', 'deskripsi' => 'Tim pengawasan pelayanan publik'],
            ['nama_tim' => 'Pengawasan Pengelolaan Informasi dan Teknologi', 'deskripsi' => 'Tim pengawasan pengelolaan informasi dan teknologi'],
        ]);

        $tim->each(function ($tim) use ($users) {
            $tim->anggota()->attach($users->random(3));
        });

        Pkpt::factory(5)->create();
    }
}
