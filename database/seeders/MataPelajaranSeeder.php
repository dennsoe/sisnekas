<?php

namespace Database\Seeders;

use App\Models\MataPelajaran;
use App\Models\Sekolah;
use Illuminate\Database\Seeder;

class MataPelajaranSeeder extends Seeder
{
    public function run(): void
    {
        $sekolah = Sekolah::first();
        
        $mapel = [
            [
                'kode_mapel' => 'MTK',
                'nama_mapel' => 'Matematika',
                'kelompok_mapel' => 'A',
                'jumlah_jam' => 4,
            ],
            [
                'kode_mapel' => 'BIN',
                'nama_mapel' => 'Bahasa Indonesia',
                'kelompok_mapel' => 'A',
                'jumlah_jam' => 4,
            ],
            [
                'kode_mapel' => 'BIG',
                'nama_mapel' => 'Bahasa Inggris',
                'kelompok_mapel' => 'A',
                'jumlah_jam' => 4,
            ],
            [
                'kode_mapel' => 'FIS',
                'nama_mapel' => 'Fisika',
                'kelompok_mapel' => 'C',
                'jumlah_jam' => 4,
            ],
            [
                'kode_mapel' => 'KIM',
                'nama_mapel' => 'Kimia',
                'kelompok_mapel' => 'C',
                'jumlah_jam' => 4,
            ],
        ];

        foreach ($mapel as $m) {
            MataPelajaran::create([
                'sekolah_id' => $sekolah->id,
                'kode_mapel' => $m['kode_mapel'],
                'nama_mapel' => $m['nama_mapel'],
                'kelompok_mapel' => $m['kelompok_mapel'],
                'tingkat_kelas' => 10,
                'jumlah_jam' => $m['jumlah_jam'],
                'kurikulum' => 'Kurikulum Merdeka',
                'aktif' => true,
            ]);
        }
    }
}