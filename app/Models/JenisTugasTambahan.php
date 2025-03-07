<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JenisTugasTambahan extends Model
{
    protected $guarded = ['id'];

    protected $fillable = [
        'sekolah_id',
        'nama_tugas',
        'kode_tugas',
        'deskripsi',
        'tunjangan_default',
        'aktif'
    ];

    protected $casts = [
        'tunjangan_default' => 'decimal:2',
        'aktif' => 'boolean'
    ];

    public function sekolah(): BelongsTo
    {
        return $this->belongsTo(Sekolah::class);
    }

    public function tugasTambahans(): HasMany
    {
        return $this->hasMany(TugasTambahan::class);
    }
}