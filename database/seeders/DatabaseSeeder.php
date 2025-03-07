<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            SekolahSeeder::class,
            GtkSeeder::class,
            RombelSeeder::class,
            MataPelajaranSeeder::class,
            SiswaSeeder::class,
            UserSeeder::class,
        ]);
    }
}
