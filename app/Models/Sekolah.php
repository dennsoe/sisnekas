<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sekolah extends Model
{
    protected $table = 'sekolahs';
    
    protected $guarded = ['id'];

    protected $fillable = [
        // Identitas Sekolah
        'npsn',
        'nama_sekolah',
        'nama_kepala_sekolah',
        'nip_kepala_sekolah',
        'status_sekolah',
        'bentuk_pendidikan',
        'status_kepemilikan',
        
        // Alamat
        'alamat_jalan',
        'rt',
        'rw',
        'nama_dusun',
        'desa_kelurahan',
        'kecamatan',
        'kabupaten_kota',
        'provinsi',
        'kode_pos',
        'lintang',
        'bujur',

        // Kontak
        'nomor_telepon',
        'nomor_fax',
        'email',
        'website',

        // Informasi Tambahan
        'sk_pendirian',
        'tanggal_sk_pendirian',
        'sk_izin_operasional',
        'tanggal_sk_izin_operasional',
        'akreditasi',
        'kurikulum'
    ];

    protected $casts = [
        'tanggal_sk_pendirian' => 'date',
        'tanggal_sk_izin_operasional' => 'date'
    ];

    public function gtks(): HasMany
    {
        return $this->hasMany(Gtk::class);
    }

    public function siswas(): HasMany
    {
        return $this->hasMany(Siswa::class);
    }

    public function rombels(): HasMany
    {
        return $this->hasMany(Rombel::class);
    }

    public function mataPelajarans(): HasMany
    {
        return $this->hasMany(MataPelajaran::class);
    }
}
