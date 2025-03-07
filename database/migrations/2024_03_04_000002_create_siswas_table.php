<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('siswas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sekolah_id')->constrained('sekolahs')->onDelete('cascade');
            
            // Identitas Siswa
            $table->string('nama');
            $table->string('nisn', 10)->unique();
            $table->string('nis', 10)->unique();
            $table->string('nik', 16)->unique();
            $table->string('no_kk', 16)->nullable();
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('agama');
            $table->string('kewarganegaraan')->default('Indonesia');
            
            // Alamat
            $table->text('alamat');
            $table->string('rt', 3);
            $table->string('rw', 3);
            $table->string('desa_kelurahan');
            $table->string('kecamatan');
            $table->string('kabupaten_kota');
            $table->string('provinsi');
            $table->string('kode_pos', 5);
            
            // Kontak
            $table->string('nomor_hp', 13);
            $table->string('email')->unique();
            
            // Riwayat Pendidikan
            $table->string('asal_sekolah');
            $table->string('nomor_ijazah_sebelumnya')->nullable();
            $table->string('nomor_skhun_sebelumnya')->nullable();
            
            // Status
            $table->boolean('aktif')->default(true);
            $table->date('tanggal_masuk');
            
            // Data Ayah
            $table->string('nama_ayah');
            $table->string('nik_ayah', 16);
            $table->string('tempat_lahir_ayah');
            $table->date('tanggal_lahir_ayah');
            $table->string('pendidikan_ayah');
            $table->string('pekerjaan_ayah');
            $table->string('penghasilan_ayah');
            
            // Data Ibu
            $table->string('nama_ibu');
            $table->string('nik_ibu', 16);
            $table->string('tempat_lahir_ibu');
            $table->date('tanggal_lahir_ibu');
            $table->string('pendidikan_ibu');
            $table->string('pekerjaan_ibu');
            $table->string('penghasilan_ibu');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('siswas');
    }
};
