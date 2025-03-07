<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sekolahs', function (Blueprint $table) {
            $table->id();
            
            // Identitas Sekolah
            $table->string('npsn', 8)->unique();
            $table->string('nama_sekolah');
            $table->string('nama_kepala_sekolah');
            $table->string('nip_kepala_sekolah', 18)->nullable();
            $table->string('status_sekolah')->default('Negeri');
            $table->string('bentuk_pendidikan');
            $table->string('status_kepemilikan');
            
            // Alamat
            $table->text('alamat_jalan');
            $table->string('rt', 3)->nullable();
            $table->string('rw', 3)->nullable();
            $table->string('nama_dusun')->nullable();
            $table->string('desa_kelurahan');
            $table->string('kecamatan');
            $table->string('kabupaten_kota');
            $table->string('provinsi');
            $table->string('kode_pos', 5);
            $table->string('lintang', 20)->nullable();
            $table->string('bujur', 20)->nullable();

            // Kontak
            $table->string('nomor_telepon')->nullable();
            $table->string('nomor_fax')->nullable();
            $table->string('email')->unique();
            $table->string('website')->nullable();

            // Informasi Tambahan
            $table->string('sk_pendirian')->nullable();
            $table->date('tanggal_sk_pendirian')->nullable();
            $table->string('sk_izin_operasional')->nullable();
            $table->date('tanggal_sk_izin_operasional')->nullable();
            $table->string('akreditasi')->nullable();
            $table->string('kurikulum')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sekolahs');
    }
};