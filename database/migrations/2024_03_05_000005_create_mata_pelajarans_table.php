<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mata_pelajarans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sekolah_id')->constrained('sekolahs')->onDelete('cascade');
            
            $table->string('nama_mapel');
            $table->string('kode_mapel')->unique();
            $table->string('kelompok_mapel');
            $table->integer('tingkat_kelas');
            $table->integer('jumlah_jam');
            $table->string('kurikulum');
            $table->boolean('aktif')->default(true);
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mata_pelajarans');
    }
};