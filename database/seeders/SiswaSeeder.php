<?php

namespace Database\Seeders;

use App\Models\Sekolah;
use App\Models\Siswa;
use Illuminate\Database\Seeder;

class SiswaSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan ada data sekolah
        $sekolah = Sekolah::first();
        
        if (!$sekolah) {
            $sekolah = Sekolah::create([
                'npsn' => '20219313',
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
            ]);
        }

        $siswa = [
            [
                'nama' => 'Ahmad Fauzi',
                'nisn' => '0123456789',
                'nis' => '2024001',
                'nik' => '3273012501080001',
                'no_kk' => '3273012501080001',
                'jenis_kelamin' => 'L',
                'tempat_lahir' => 'Bandung',
                'tanggal_lahir' => '2008-01-25',
                'agama' => 'Islam',
                'kewarganegaraan' => 'Indonesia',
                'alamat' => 'Jl. Dipatiukur No. 123',
                'rt' => '002',
                'rw' => '003',
                'desa_kelurahan' => 'Lebakgede',
                'kecamatan' => 'Coblong',
                'kabupaten_kota' => 'Kota Bandung',
                'provinsi' => 'Jawa Barat',
                'kode_pos' => '40132',
                'nomor_hp' => '081234567890',
                'email' => 'ahmad.fauzi@gmail.com',
                'asal_sekolah' => 'SMP Negeri 1 Bandung',
                'nomor_ijazah_sebelumnya' => 'DN-01 Mk 0123456',
                'nomor_skhun_sebelumnya' => 'DN-02 Mk 0123456',
                'tanggal_masuk' => '2024-07-15',
                'nama_ayah' => 'Budi Santoso',
                'nik_ayah' => '3273010101750001',
                'tempat_lahir_ayah' => 'Bandung',
                'tanggal_lahir_ayah' => '1975-01-01',
                'pendidikan_ayah' => 'S1',
                'pekerjaan_ayah' => 'Wiraswasta',
                'penghasilan_ayah' => '5000000-10000000',
                'nama_ibu' => 'Siti Aminah',
                'nik_ibu' => '3273010101780002',
                'tempat_lahir_ibu' => 'Bandung',
                'tanggal_lahir_ibu' => '1978-01-01',
                'pendidikan_ibu' => 'S1',
                'pekerjaan_ibu' => 'Guru',
                'penghasilan_ibu' => '5000000-10000000',
            ],
            [
                'nama' => 'Siti Nurhaliza',
                'nisn' => '0123456790',
                'nis' => '2024002',
                'nik' => '3273012502080002',
                'no_kk' => '3273012502080002',
                'jenis_kelamin' => 'P',
                'tempat_lahir' => 'Bandung',
                'tanggal_lahir' => '2008-02-25',
                'agama' => 'Islam',
                'kewarganegaraan' => 'Indonesia',
                'alamat' => 'Jl. Dago No. 456',
                'rt' => '004',
                'rw' => '005',
                'desa_kelurahan' => 'Dago',
                'kecamatan' => 'Coblong',
                'kabupaten_kota' => 'Kota Bandung',
                'provinsi' => 'Jawa Barat',
                'kode_pos' => '40135',
                'nomor_hp' => '081234567891',
                'email' => 'siti.nurhaliza@gmail.com',
                'asal_sekolah' => 'SMP Negeri 2 Bandung',
                'nomor_ijazah_sebelumnya' => 'DN-01 Mk 0123457',
                'nomor_skhun_sebelumnya' => 'DN-02 Mk 0123457',
                'tanggal_masuk' => '2024-07-15',
                'nama_ayah' => 'Ahmad Suparman',
                'nik_ayah' => '3273010101760001',
                'tempat_lahir_ayah' => 'Bandung',
                'tanggal_lahir_ayah' => '1976-01-01',
                'pendidikan_ayah' => 'S1',
                'pekerjaan_ayah' => 'PNS',
                'penghasilan_ayah' => '5000000-10000000',
                'nama_ibu' => 'Yani Suryani',
                'nik_ibu' => '3273010101790002',
                'tempat_lahir_ibu' => 'Bandung',
                'tanggal_lahir_ibu' => '1979-01-01',
                'pendidikan_ibu' => 'S1',
                'pekerjaan_ibu' => 'PNS',
                'penghasilan_ibu' => '5000000-10000000',
            ],
        ];

        foreach ($siswa as $s) {
            Siswa::create([
                'sekolah_id' => $sekolah->id,
                'nama' => $s['nama'],
                'nisn' => $s['nisn'],
                'nis' => $s['nis'],
                'nik' => $s['nik'],
                'no_kk' => $s['no_kk'],
                'jenis_kelamin' => $s['jenis_kelamin'],
                'tempat_lahir' => $s['tempat_lahir'],
                'tanggal_lahir' => $s['tanggal_lahir'],
                'agama' => $s['agama'],
                'kewarganegaraan' => $s['kewarganegaraan'],
                'alamat' => $s['alamat'],
                'rt' => $s['rt'],
                'rw' => $s['rw'],
                'desa_kelurahan' => $s['desa_kelurahan'],
                'kecamatan' => $s['kecamatan'],
                'kabupaten_kota' => $s['kabupaten_kota'],
                'provinsi' => $s['provinsi'],
                'kode_pos' => $s['kode_pos'],
                'nomor_hp' => $s['nomor_hp'],
                'email' => $s['email'],
                'asal_sekolah' => $s['asal_sekolah'],
                'nomor_ijazah_sebelumnya' => $s['nomor_ijazah_sebelumnya'],
                'nomor_skhun_sebelumnya' => $s['nomor_skhun_sebelumnya'],
                'aktif' => true,
                'tanggal_masuk' => $s['tanggal_masuk'],
                'nama_ayah' => $s['nama_ayah'],
                'nik_ayah' => $s['nik_ayah'],
                'tempat_lahir_ayah' => $s['tempat_lahir_ayah'],
                'tanggal_lahir_ayah' => $s['tanggal_lahir_ayah'],
                'pendidikan_ayah' => $s['pendidikan_ayah'],
                'pekerjaan_ayah' => $s['pekerjaan_ayah'],
                'penghasilan_ayah' => $s['penghasilan_ayah'],
                'nama_ibu' => $s['nama_ibu'],
                'nik_ibu' => $s['nik_ibu'],
                'tempat_lahir_ibu' => $s['tempat_lahir_ibu'],
                'tanggal_lahir_ibu' => $s['tanggal_lahir_ibu'],
                'pendidikan_ibu' => $s['pendidikan_ibu'],
                'pekerjaan_ibu' => $s['pekerjaan_ibu'],
                'penghasilan_ibu' => $s['penghasilan_ibu'],
            ]);
        }
    }
}



