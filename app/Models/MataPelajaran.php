<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MataPelajaran extends Model
{
    protected $table = 'mata_pelajarans';
    
    protected $fillable = [
        'sekolah_id',
        'nama_mapel',
        'kode_mapel',
        'kelompok_mapel',
        'tingkat_kelas',
        'jumlah_jam',
        'kurikulum',
        'aktif'
    ];

    protected $casts = [
        'aktif' => 'boolean',
        'tingkat_kelas' => 'integer',
        'jumlah_jam' => 'integer'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->sekolah_id) {
                $model->sekolah_id = Sekolah::first()?->id;
            }
            if (!$model->aktif) {
                $model->aktif = true;
            }
        });
    }

    public function sekolah(): BelongsTo
    {
        return $this->belongsTo(Sekolah::class);
    }
}
