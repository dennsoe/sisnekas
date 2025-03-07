<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Gtk;
use App\Models\Siswa;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@admin.com', // Ubah email
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'role' => 'admin',
        ]);

        // Create users for GTK (Guru dan Tenaga Kependidikan)
        $gtkList = Gtk::all();
        foreach ($gtkList as $gtk) {
            User::create([
                'name' => $gtk->nama,
                'email' => $gtk->email,
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'role' => $gtk->role,
                'userable_id' => $gtk->id,
                'userable_type' => Gtk::class,
            ]);
        }

        // Create users for Siswa
        $siswaList = Siswa::all();
        foreach ($siswaList as $siswa) {
            User::create([
                'name' => $siswa->nama,
                'email' => $siswa->email,
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'role' => 'siswa',
                'userable_id' => $siswa->id,
                'userable_type' => Siswa::class,
            ]);
        }
    }
}