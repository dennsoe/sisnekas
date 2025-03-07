<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('gtks', function (Blueprint $table) {
            $table->id();
            
            // IDENTITAS SEKOLAH
            $table->foreignId('sekolah_id')->constrained('sekolahs')->onDelete('cascade');
            $table->string('npsn', 20)->nullable();
            $table->string('nama_sekolah')->nullable();

            // IDENTITAS GTK
            $table->string('nama');
            $table->string('nik', 16)->unique();
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('tempat_lahir', 100);
            $table->date('tanggal_lahir');
            $table->string('nama_ibu_kandung');

            // ALAMAT LENGKAP
            $table->string('alamat');
            $table->string('rt', 10)->nullable();
            $table->string('rw', 10)->nullable();
            $table->string('nama_dusun', 100)->nullable();
            $table->string('desa_kelurahan', 100)->nullable();
            $table->string('kecamatan', 100)->nullable();
            $table->string('kabupaten_kota', 100)->nullable();
            $table->string('provinsi', 100)->nullable();
            $table->string('kode_pos', 10)->nullable();
            $table->string('lintang', 20)->nullable();
            $table->string('bujur', 20)->nullable();
            $table->string('no_kk', 20)->nullable();

            // NPWP
            $table->string('npwp', 20)->nullable();
            $table->string('nama_wajib_pajak')->nullable();

            // KEWARGANEGARAAN
            $table->string('kewarganegaraan', 50)->nullable();
            $table->string('negara_asal', 50)->nullable();

            // STATUS PERKAWINAN
            $table->enum('status_perkawinan', ['Kawin', 'Belum Kawin', 'Janda/Duda'])->nullable();
            $table->string('nama_suami_istri')->nullable();
            $table->string('nip_suami_istri', 20)->nullable();
            $table->string('pekerjaan_suami_istri', 50)->nullable();

            // STATUS KEPEGAWAIAN
            $table->string('status_kepegawaian', 50)->nullable();
            $table->string('nip', 20)->unique()->nullable();
            $table->string('niy_nigk', 20)->nullable();
            $table->string('nuptk', 20)->unique()->nullable();
            $table->string('jenis_ptk', 50)->nullable();
            $table->string('sk_pengangkatan', 50)->nullable();
            $table->date('tmt_pengangkatan')->nullable();
            $table->string('lembaga_pengangkat', 50)->nullable();
            $table->string('sk_cpns', 50)->nullable();
            $table->date('tmt_cpns')->nullable();
            $table->string('sk_pns', 50)->nullable();
            $table->date('tmt_pns')->nullable();
            $table->string('pangkat_golongan', 10)->nullable();
            $table->string('sumber_gaji', 50)->nullable();
            $table->string('nomor_karpeg', 50)->nullable();
            $table->string('nomor_karis_karsu', 50)->nullable();

            // KOMPETENSI KHUSUS
            $table->boolean('lisensi_kepala_sekolah')->default(false);
            $table->string('nuks', 50)->nullable();
            $table->string('keahlian_laboratorium', 100)->nullable();
            $table->string('mampu_menangani_kebutuhan_khusus', 100)->nullable();
            $table->boolean('keahlian_braille')->default(false);
            $table->boolean('keahlian_bahasa_isyarat')->default(false);

            // KONTAK & AUTENTIKASI
            $table->string('no_telp_rumah', 20)->nullable();
            $table->string('no_hp', 20)->nullable();
            $table->string('email', 100)->unique();
            $table->string('password');
            $table->enum('role', ['admin', 'operator', 'guru', 'kepala_sekolah', 'tendik'])->default('guru');

            // PENUGASAN
            $table->string('nomor_surat_tugas', 50)->nullable();
            $table->date('tanggal_surat_tugas')->nullable();
            $table->date('tmt_tugas')->nullable();
            $table->boolean('status_sekolah_induk')->default(false);

            // DATA KELUAR
            $table->string('alasan_keluar', 50)->nullable();
            $table->date('tanggal_keluar')->nullable();

            // DATA REKENING BANK
            $table->string('nama_bank', 100)->nullable();
            $table->string('pemilik_rekening')->nullable();
            $table->string('nomor_rekening', 50)->unique()->nullable();

            // RIWAYAT SERTIFIKASI
            $table->json('riwayat_sertifikasi')->nullable();

            // RIWAYAT PENDIDIKAN
            $table->json('riwayat_pendidikan')->nullable();

            // DATA ANAK
            $table->string('nama_anak_1')->nullable();
            $table->string('nama_anak_2')->nullable();
            $table->string('nama_anak_3')->nullable();
            $table->string('nama_anak_4')->nullable();

            // BEASISWA & TUNJANGAN
            $table->string('jenis_beasiswa', 100)->nullable();
            $table->text('keterangan_beasiswa')->nullable();
            $table->integer('tahun_mulai_beasiswa')->nullable();
            $table->integer('tahun_akhir_beasiswa')->nullable();
            $table->boolean('masih_menerima_beasiswa')->default(false);
            $table->string('jenis_tunjangan', 50)->nullable();
            $table->string('nama_tunjangan')->nullable();
            $table->string('instansi_pemberi_tunjangan')->nullable();
            $table->string('sk_tunjangan', 50)->nullable();
            $table->date('tgl_sk_tunjangan')->nullable();
            $table->string('sumber_dana', 50)->nullable();
            $table->integer('tahun_mulai_tunjangan')->nullable();
            $table->integer('tahun_akhir_tunjangan')->nullable();
            $table->decimal('nominal_tunjangan', 15, 2)->nullable();
            $table->string('status_tunjangan', 50)->nullable();

            // TUGAS TAMBAHAN
            $table->string('jabatan_tugas_tambahan', 100)->nullable();
            $table->string('nomor_sk_tugas_tambahan', 50)->nullable();
            $table->date('tmt_tugas_tambahan')->nullable();
            $table->date('tst_tugas_tambahan')->nullable();

            // PENGHARGAAN
            $table->string('tingkat_penghargaan', 50)->nullable();
            $table->string('jenis_penghargaan', 100)->nullable();
            $table->string('nama_penghargaan')->nullable();
            $table->integer('tahun_penghargaan')->nullable();
            $table->string('instansi_penghargaan')->nullable();

            // RIWAYAT GAJI BERKALA
            $table->string('nomor_sk_kgb', 50)->nullable();
            $table->date('tanggal_sk_kgb')->nullable();
            $table->date('tmt_kgb')->nullable();
            $table->integer('masa_kerja_tahun')->nullable();
            $table->integer('masa_kerja_bulan')->nullable();
            $table->decimal('gaji_pokok', 15, 2)->nullable();

            // RIWAYAT KARIR
            $table->json('riwayat_karir')->nullable();

            // TIMESTAMPS
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gtks');
    }
};
