<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Rombel;
use App\Models\MataPelajaran;

class Gtk extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $table = 'gtks';
    
    protected $queryString = [
        'tab' => [
            'except' => 'sekolah'
        ]
    ];

    protected $guarded = ['id'];

    protected $fillable = [
        // IDENTITAS SEKOLAH
        'sekolah_id',
        'npsn',
        'nama_sekolah',

        // IDENTITAS GTK
        'nama',
        'nik',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'nama_ibu_kandung',

        // ALAMAT LENGKAP
        'alamat',
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
        'no_kk',

        // NPWP
        'npwp',
        'nama_wajib_pajak',

        // KEWARGANEGARAAN
        'kewarganegaraan',
        'negara_asal',

        // STATUS PERKAWINAN
        'status_perkawinan',
        'nama_suami_istri',
        'nip_suami_istri',
        'pekerjaan_suami_istri',

        // STATUS KEPEGAWAIAN
        'status_kepegawaian',
        'nip',
        'niy_nigk',
        'nuptk',
        'jenis_ptk',
        'sk_pengangkatan',
        'tmt_pengangkatan',
        'lembaga_pengangkat',
        'sk_cpns',
        'tmt_cpns',
        'sk_pns',
        'tmt_pns',
        'pangkat_golongan',
        'sumber_gaji',
        'nomor_karpeg',
        'nomor_karis_karsu',

        // KOMPETENSI KHUSUS
        'lisensi_kepala_sekolah',
        'nuks',
        'keahlian_laboratorium',
        'mampu_menangani_kebutuhan_khusus',
        'keahlian_braille',
        'keahlian_bahasa_isyarat',

        // KONTAK & AUTENTIKASI
        'no_telp_rumah',
        'no_hp',
        'email',
        'password',
        'role',

        // PENUGASAN
        'nomor_surat_tugas',
        'tanggal_surat_tugas',
        'tmt_tugas',
        'status_sekolah_induk',

        // DATA KELUAR
        'alasan_keluar',
        'tanggal_keluar',

        // DATA REKENING BANK
        'nama_bank',
        'pemilik_rekening',
        'nomor_rekening',

        // RIWAYAT SERTIFIKASI
        'riwayat_sertifikasi',

        // RIWAYAT PENDIDIKAN FORMAL
        'jenjang_pendidikan',
        'gelar_akademik',
        'satuan_pendidikan',
        'fakultas',
        'kependidikan',
        'tahun_masuk',
        'tahun_lulus',
        'nim',
        'ipk',
        'semester',
        'rata_rata_ujian_akhir',
        'riwayat_pendidikan',

        // DATA ANAK
        'nama_anak_1',
        'nama_anak_2',
        'nama_anak_3',
        'nama_anak_4',

        // BEASISWA & TUNJANGAN
        'jenis_beasiswa',
        'keterangan_beasiswa',
        'tahun_mulai_beasiswa',
        'tahun_akhir_beasiswa',
        'masih_menerima_beasiswa',
        'jenis_tunjangan',
        'nama_tunjangan',
        'instansi_pemberi_tunjangan',
        'sk_tunjangan',
        'tgl_sk_tunjangan',
        'sumber_dana',
        'tahun_mulai_tunjangan',
        'tahun_akhir_tunjangan',
        'nominal_tunjangan',
        'status_tunjangan',

        // TUGAS TAMBAHAN
        'jabatan_tugas_tambahan',
        'nomor_sk_tugas_tambahan',
        'tmt_tugas_tambahan',
        'tst_tugas_tambahan',

        // PENGHARGAAN
        'tingkat_penghargaan',
        'jenis_penghargaan',
        'nama_penghargaan',
        'tahun_penghargaan',
        'instansi_penghargaan',

        // RIWAYAT GAJI BERKALA
        'nomor_sk_kgb',
        'tanggal_sk_kgb',
        'tmt_kgb',
        'masa_kerja_tahun',
        'masa_kerja_bulan',
        'gaji_pokok',

        // RIWAYAT KARIR
        'riwayat_karir',
        'riwayat_kepangkatan',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        // Dates
        'tanggal_lahir' => 'date',
        'tmt_pengangkatan' => 'date',
        'tmt_cpns' => 'date',
        'tmt_pns' => 'date',
        'tanggal_surat_tugas' => 'date',
        'tmt_tugas' => 'date',
        'tanggal_keluar' => 'date',
        'tgl_sk_tunjangan' => 'date',
        'tmt_tugas_tambahan' => 'date',
        'tst_tugas_tambahan' => 'date',
        'tanggal_sk_kgb' => 'date',
        'tmt_kgb' => 'date',

        // Booleans
        'lisensi_kepala_sekolah' => 'boolean',
        'keahlian_braille' => 'boolean',
        'keahlian_bahasa_isyarat' => 'boolean',
        'status_sekolah_induk' => 'boolean',
        'kependidikan' => 'boolean',
        'masih_menerima_beasiswa' => 'boolean',

        // Numbers
        'ipk' => 'decimal:2',
        'rata_rata_ujian_akhir' => 'decimal:2',
        'nominal_tunjangan' => 'decimal:2',
        'gaji_pokok' => 'decimal:2',
        'tahun_sertifikasi' => 'integer',
        'tahun_masuk' => 'integer',
        'tahun_lulus' => 'integer',
        'semester' => 'integer',
        'tahun_mulai_beasiswa' => 'integer',
        'tahun_akhir_beasiswa' => 'integer',
        'tahun_mulai_tunjangan' => 'integer',
        'tahun_akhir_tunjangan' => 'integer',
        'tahun_penghargaan' => 'integer',
        'masa_kerja_tahun' => 'integer',
        'masa_kerja_bulan' => 'integer',

        // Arrays
        'riwayat_karir' => 'array',
        'riwayat_pendidikan' => 'array',
        'riwayat_kepangkatan' => 'array',
        'riwayat_sertifikasi' => 'array',

        // Enums
        'jenis_kelamin' => 'string',
        'status_perkawinan' => 'string',
        'role' => 'string',
    ];

    // Constants
    const JENIS_KELAMIN = ['L', 'P'];
    const STATUS_PERKAWINAN = ['Kawin', 'Belum Kawin', 'Janda/Duda'];
    const ROLES = ['admin', 'operator', 'guru', 'kepala_sekolah', 'tendik'];

    // Relationships
    public function sekolah(): BelongsTo
    {
        return $this->belongsTo(Sekolah::class, 'sekolah_id');
    }

    public function rombelsAsWaliKelas(): HasMany
    {
        return $this->hasMany(Rombel::class, 'wali_kelas_id');
    }

    public function rombelsPengajar(): BelongsToMany
    {
        return $this->belongsToMany(Rombel::class, 'rombel_pembelajaran')
            ->withPivot(['mata_pelajaran_id', 'jam_mengajar', 'status_pembelajaran'])
            ->withTimestamps();
    }

    // Scopes
    public function scopeAktif($query)
    {
        return $query->whereNull('tanggal_keluar');
    }

    public function scopeByRole($query, $role)
    {
        return $query->where('role', $role);
    }

    public function scopeSertifikasi($query)
    {
        return $query->whereNotNull('nomor_sertifikasi');
    }

    public function scopePns($query)
    {
        return $query->whereNotNull('nip');
    }

    // Accessors
    public function getNamaLengkapAttribute(): string
    {
        return $this->gelar_akademik 
            ? "{$this->nama}, {$this->gelar_akademik}"
            : $this->nama;
    }

    public function getAlamatLengkapAttribute(): string
    {
        $parts = [
            $this->alamat,
            $this->rt ? "RT {$this->rt}" : null,
            $this->rw ? "RW {$this->rw}" : null,
            $this->nama_dusun,
            $this->desa_kelurahan,
            $this->kecamatan,
            $this->kabupaten_kota,
            $this->provinsi,
            $this->kode_pos
        ];

        return implode(', ', array_filter($parts));
    }

    public function getMasaKerjaAttribute(): string
    {
        return "{$this->masa_kerja_tahun} tahun {$this->masa_kerja_bulan} bulan";
    }

    public function formatRiwayatPendidikan(): string
    {
        if (empty($this->riwayat_pendidikan)) {
            return '-';
        }

        return collect($this->riwayat_pendidikan)
            ->map(function ($item) {
                $details = [];
                if (!empty($item['jenjang'])) $details[] = $item['jenjang'];
                if (!empty($item['gelar_akademik'])) $details[] = $item['gelar_akademik'];
                if (!empty($item['satuan_pendidikan'])) $details[] = $item['satuan_pendidikan'];
                if (!empty($item['tahun_lulus'])) $details[] = "Lulus: " . $item['tahun_lulus'];
                
                return implode(' - ', array_filter($details));
            })
            ->join(', ');
    }
}
