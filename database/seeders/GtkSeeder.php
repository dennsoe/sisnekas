<?php

namespace Database\Seeders;

use App\Models\Gtk;
use App\Models\Sekolah;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class GtkSeeder extends Seeder
{
    public function run(): void
    {
        $sekolah = Sekolah::first();

        // Kepala Sekolah
        Gtk::create([
            'sekolah_id' => $sekolah->id,
            'npsn' => $sekolah->npsn,
            'nama_sekolah' => $sekolah->nama_sekolah,
            'nama' => 'Dr. H. Ahmad Hidayat, M.Pd.',
            'nik' => '3273010101660002', // Ubah NIK
            'nip' => '196601011990011001',
            'jenis_kelamin' => 'L',
            'tempat_lahir' => 'Bandung',
            'tanggal_lahir' => '1966-01-01',
            'nama_ibu_kandung' => 'Siti Aminah',
            'email' => 'ahmad.hidayat@sch.id',
            'password' => Hash::make('password'),
            'role' => 'kepala_sekolah',
            'status_kepegawaian' => 'PNS',
            'jenis_ptk' => 'Kepala Sekolah',
            'pangkat_golongan' => 'IV/b',
            'alamat' => 'Juanda',
            'desa_kelurahan' => 'Tamansari',
            'kecamatan' => 'Bandung Wetan',
            'kabupaten_kota' => 'Kota Bandung',
            'provinsi' => 'Jawa Barat',
        ]);

        // Guru Matematika
        Gtk::create([
            'sekolah_id' => $sekolah->id,
            'npsn' => $sekolah->npsn,
            'nama_sekolah' => $sekolah->nama_sekolah,
            'nama' => 'Dra. Siti Rahayu, M.Pd.',
            'nik' => '3273015501700003', // Ubah NIK
            'nip' => '197001151995122001',
            'jenis_kelamin' => 'P',
            'tempat_lahir' => 'Bandung',
            'tanggal_lahir' => '1970-01-15',
            'nama_ibu_kandung' => 'Yayah Sopiah',
            'email' => 'siti.rahayu@sch.id',
            'password' => Hash::make('password'),
            'role' => 'guru',
            'status_kepegawaian' => 'PNS',
            'jenis_ptk' => 'Guru Mata Pelajaran',
            'pangkat_golongan' => 'IV/a',
            'alamat' => 'juanda',
            'desa_kelurahan' => 'Tamansari',
            'kecamatan' => 'Bandung Wetan',
            'kabupaten_kota' => 'Kota Bandung',
            'provinsi' => 'Jawa Barat',
        ]);
    }
}
