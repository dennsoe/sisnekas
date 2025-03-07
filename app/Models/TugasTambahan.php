<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TugasTambahan extends Model
{
    protected $guarded = ['id'];

    protected $fillable = [
        'sekolah_id',
        'gtk_id',
        'jenis_tugas_tambahan_id',
        'jabatan',
        'nomor_sk',
        'tmt_tugas',
        'tst_tugas',
        'keterangan',
        'aktif',
        'tunjangan'
    ];

    protected $casts = [
        'tmt_tugas' => 'date',
        'tst_tugas' => 'date',
        'aktif' => 'boolean',
        'tunjangan' => 'decimal:2'
    ];

    public function sekolah(): BelongsTo
    {
        return $this->belongsTo(Sekolah::class);
    }

    public function gtk(): BelongsTo
    {
        return $this->belongsTo(Gtk::class);
    }

    public function jenisTugasTambahan(): BelongsTo
    {
        return $this->belongsTo(JenisTugasTambahan::class);
    }
}
