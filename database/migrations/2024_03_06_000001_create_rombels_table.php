<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rombels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sekolah_id')->constrained('sekolahs')->onDelete('cascade');
            $table->foreignId('wali_kelas_id')->nullable()->constrained('gtks')->onDelete('set null');
            $table->string('nama_rombel');
            $table->integer('tingkat');
            $table->string('jurusan')->nullable();
            $table->integer('tahun_ajaran');
            $table->enum('semester', ['ganjil', 'genap']);
            $table->integer('kuota');
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rombels');
    }
};