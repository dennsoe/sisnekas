<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Rombel extends Model
{
    protected $table = 'rombels';

    protected $fillable = [
        'sekolah_id',
        'wali_kelas_id',
        'nama_rombel',
        'tingkat',
        'jurusan',
        'tahun_ajaran',
        'semester',
        'kuota',
        'aktif',
    ];

    protected $casts = [
        'aktif' => 'boolean',
    ];

    public function sekolah(): BelongsTo
    {
        return $this->belongsTo(Sekolah::class);
    }

    public function waliKelas(): BelongsTo
    {
        return $this->belongsTo(Gtk::class, 'wali_kelas_id');
    }

    public function siswa(): BelongsToMany
    {
        return $this->belongsToMany(Siswa::class, 'rombel_siswa')
            ->withTimestamps();
    }

    // Tambahkan relasi pembelajaran
    public function pembelajaran(): BelongsToMany
    {
        return $this->belongsToMany(MataPelajaran::class, 'rombel_pembelajaran')
            ->withPivot(['gtk_id', 'jam_mengajar', 'status_pembelajaran'])
            ->withTimestamps();
    }

    // Tambahkan relasi guru untuk pembelajaran
    public function guru(): BelongsToMany
    {
        return $this->belongsToMany(Gtk::class, 'rombel_pembelajaran')
            ->withPivot(['mata_pelajaran_id', 'jam_mengajar', 'status_pembelajaran'])
            ->withTimestamps();
    }
}
