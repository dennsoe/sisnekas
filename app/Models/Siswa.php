<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Siswa extends Model
{
    protected $table = 'siswas';

    protected $guarded = ['id'];

    protected $fillable = [
        'sekolah_id',
        'nama',
        'nisn',
        'nis',
        'nik',
        'no_kk',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'agama',
        'kewarganegaraan',
        'nomor_hp',
        'email',
        'asal_sekolah',
        'nomor_ijazah_sebelumnya',
        'nomor_skhun_sebelumnya',
        'aktif',
        'tanggal_masuk',
        'tanggal_keluar',
        'alasan_keluar',
        'alamat',
        'rt',
        'rw',
        'provinsi',
        'kabupaten_kota',
        'kecamatan',
        'desa_kelurahan',
        'kode_pos',
        'nama_ayah',
        'nik_ayah',
        'pekerjaan_ayah',
        'penghasilan_ayah',
        'nama_ibu',
        'nik_ibu',
        'pekerjaan_ibu',
        'penghasilan_ibu',
        'has_wali',
        'nama_wali',
        'nik_wali',
        'pekerjaan_wali',
        'penghasilan_wali',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'tanggal_lahir_wali' => 'date',
        'tanggal_masuk' => 'date',
        'tanggal_keluar' => 'date',
        'aktif' => 'boolean',
        'has_wali' => 'boolean',
        // Ubah casting untuk penghasilan menjadi integer atau string
        'penghasilan_ayah' => 'integer',
        'penghasilan_ibu' => 'integer',
        'penghasilan_wali' => 'integer',
    ];

    public function sekolah(): BelongsTo
    {
        return $this->belongsTo(Sekolah::class);
    }

    public function rombels(): BelongsToMany
    {
        return $this->belongsToMany(Rombel::class, 'rombel_siswa')
            ->withTimestamps();
    }
}
