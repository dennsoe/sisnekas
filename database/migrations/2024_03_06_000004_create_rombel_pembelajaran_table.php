<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rombel_pembelajaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rombel_id')->constrained()->onDelete('cascade');
            $table->foreignId('mata_pelajaran_id')->constrained('mata_pelajarans')->onDelete('cascade');
            $table->foreignId('gtk_id')->nullable()->constrained('gtks')->onDelete('set null');
            $table->integer('jam_mengajar');
            $table->enum('status_pembelajaran', ['aktif', 'nonaktif'])->default('aktif');
            $table->timestamps();

            $table->unique(['rombel_id', 'mata_pelajaran_id', 'gtk_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rombel_pembelajaran');
    }
};