<?php

namespace Database\Seeders;

use App\Models\Sekolah;
use Illuminate\Database\Seeder;

class SekolahSeeder extends Seeder
{
    public function run(): void
    {
        Sekolah::create([
            'npsn' => '20219313', // Ubah NPSN yang sudah ada
            'nama_sekolah' => 'SMA Negeri 1 Bandung',
            'nama_kepala_sekolah' => 'Dr. H. Ahmad Hidayat, M.Pd.',
            'nip_kepala_sekolah' => '196601011990011001',
            'email' => 'sman1bandung@sch.id',
            'status_sekolah' => 'Negeri',
            'bentuk_pendidikan' => 'SMA',
            'status_kepemilikan' => 'Pemerintah Daerah',
            'sk_pendirian' => '421.3/KEP.00892-DISDIK/2015',
            'tanggal_sk_pendirian' => '1950-08-30',
            'sk_izin_operasional' => '421.3/KEP.00892-DISDIK/2015',
            'tanggal_sk_izin_operasional' => '2015-01-01',
            'alamat_jalan' => 'Jl. Ir. H. Juanda No. 93',
            'rt' => '001',
            'rw' => '001',
            'desa_kelurahan' => 'Tamansari',
            'kecamatan' => 'Bandung Wetan',
            'kabupaten_kota' => 'Kota Bandung',
            'provinsi' => 'Jawa Barat',
            'kode_pos' => '40116',
            'lintang' => '-6.902290',
            'bujur' => '107.610730',
            'nomor_telepon' => '022-4205226',
            'nomor_fax' => '022-4205226',
            'website' => 'https://sman1bdg.sch.id',
        ]);
    }
}
