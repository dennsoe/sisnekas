<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('siswas', function (Blueprint $table) {
            $table->string('no_kk', 16)->nullable()->change();
            $table->string('nomor_hp')->nullable()->change();
            $table->string('email')->nullable()->change();
            $table->string('asal_sekolah')->nullable()->change();
            $table->string('nomor_ijazah_sebelumnya')->nullable()->change();
            $table->string('nomor_skhun_sebelumnya')->nullable()->change();
            $table->string('rt', 3)->nullable()->change();
            $table->string('rw', 3)->nullable()->change();
            $table->string('kode_pos', 5)->nullable()->change();
            $table->string('nik_ayah', 16)->nullable()->change();
            $table->string('pekerjaan_ayah')->nullable()->change();
            $table->string('penghasilan_ayah')->nullable()->change();
            $table->string('nik_ibu', 16)->nullable()->change();
            $table->string('pekerjaan_ibu')->nullable()->change();
            $table->string('penghasilan_ibu')->nullable()->change();
            $table->string('pekerjaan_wali')->nullable()->change();
            $table->string('penghasilan_wali')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('siswas', function (Blueprint $table) {
            $table->string('no_kk', 16)->nullable(false)->change();
            $table->string('nomor_hp')->nullable(false)->change();
            $table->string('email')->nullable(false)->change();
            $table->string('asal_sekolah')->nullable(false)->change();
            $table->string('nomor_ijazah_sebelumnya')->nullable(false)->change();
            $table->string('nomor_skhun_sebelumnya')->nullable(false)->change();
            $table->string('rt', 3)->nullable(false)->change();
            $table->string('rw', 3)->nullable(false)->change();
            $table->string('kode_pos', 5)->nullable(false)->change();
            $table->string('nik_ayah', 16)->nullable(false)->change();
            $table->string('pekerjaan_ayah')->nullable(false)->change();
            $table->string('penghasilan_ayah')->nullable(false)->change();
            $table->string('nik_ibu', 16)->nullable(false)->change();
            $table->string('pekerjaan_ibu')->nullable(false)->change();
            $table->string('penghasilan_ibu')->nullable(false)->change();
            $table->string('pekerjaan_wali')->nullable(false)->change();
            $table->string('penghasilan_wali')->nullable(false)->change();
        });
    }
};
