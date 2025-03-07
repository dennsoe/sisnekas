<?php

namespace Database\Seeders;

use App\Models\Rombel;
use App\Models\Sekolah;
use App\Models\Gtk;
use Illuminate\Database\Seeder;

class RombelSeeder extends Seeder
{
    public function run(): void
    {
        $sekolah = Sekolah::first();
        $walikelas = Gtk::where('role', 'guru')->first();

        $rombel = [
            // Kelas X
            [
                'nama_rombel' => 'X-ATPH A',
                'tingkat' => 10,
                'jurusan' => 'Agribisnis Tanaman Pangan dan Hortikultura',
            ],
            [
                'nama_rombel' => 'X-ATPH B',
                'tingkat' => 10,
                'jurusan' => 'Agribisnis Tanaman Pangan dan Hortikultura',
            ],
            [
                'nama_rombel' => 'X-RPL A',
                'tingkat' => 10,
                'jurusan' => 'Rekayasa Perangkat Lunak',
            ],
            [
                'nama_rombel' => 'X-RPL B',
                'tingkat' => 10,
                'jurusan' => 'Rekayasa Perangkat Lunak',
            ],
            [
                'nama_rombel' => 'X-RPL C',
                'tingkat' => 10,
                'jurusan' => 'Rekayasa Perangkat Lunak',
            ],
            [
                'nama_rombel' => 'X-TSM A',
                'tingkat' => 10,
                'jurusan' => 'Teknik Sepeda Motor',
            ],
            [
                'nama_rombel' => 'X-TSM B',
                'tingkat' => 10,
                'jurusan' => 'Teknik Sepeda Motor',
            ],

            // Kelas XI
            [
                'nama_rombel' => 'XI-ATPH',
                'tingkat' => 11,
                'jurusan' => 'Agribisnis Tanaman Pangan dan Hortikultura',
            ],
            [
                'nama_rombel' => 'XI-RPL A',
                'tingkat' => 11,
                'jurusan' => 'Rekayasa Perangkat Lunak',
            ],
            [
                'nama_rombel' => 'XI-RPL B',
                'tingkat' => 11,
                'jurusan' => 'Rekayasa Perangkat Lunak',
            ],
            [
                'nama_rombel' => 'XI-RPL C',
                'tingkat' => 11,
                'jurusan' => 'Rekayasa Perangkat Lunak',
            ],
            [
                'nama_rombel' => 'XI-TSM A',
                'tingkat' => 11,
                'jurusan' => 'Teknik Sepeda Motor',
            ],
            [
                'nama_rombel' => 'XI-TSM B',
                'tingkat' => 11,
                'jurusan' => 'Teknik Sepeda Motor',
            ],
            [
                'nama_rombel' => 'XI-TSM C',
                'tingkat' => 11,
                'jurusan' => 'Teknik Sepeda Motor',
            ],

            // Kelas XII
            [
                'nama_rombel' => 'XII-ATPH',
                'tingkat' => 12,
                'jurusan' => 'Agribisnis Tanaman Pangan dan Hortikultura',
            ],
            [
                'nama_rombel' => 'XII-RPL A',
                'tingkat' => 12,
                'jurusan' => 'Rekayasa Perangkat Lunak',
            ],
            [
                'nama_rombel' => 'XII-RPL B',
                'tingkat' => 12,
                'jurusan' => 'Rekayasa Perangkat Lunak',
            ],
            [
                'nama_rombel' => 'XII-RPL C',
                'tingkat' => 12,
                'jurusan' => 'Rekayasa Perangkat Lunak',
            ],
            [
                'nama_rombel' => 'XII-TSM A',
                'tingkat' => 12,
                'jurusan' => 'Teknik Sepeda Motor',
            ],
            [
                'nama_rombel' => 'XII-TSM B',
                'tingkat' => 12,
                'jurusan' => 'Teknik Sepeda Motor',
            ],
        ];

        foreach ($rombel as $r) {
            Rombel::create([
                'sekolah_id' => $sekolah->id,
                'wali_kelas_id' => $walikelas->id,
                'nama_rombel' => $r['nama_rombel'],
                'tingkat' => $r['tingkat'],
                'jurusan' => $r['jurusan'],
                'tahun_ajaran' => '2024',
                'semester' => 'ganjil',
                'kuota' => 32,
                'aktif' => true,
            ]);
        }
    }
}
