<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('siswas', function (Blueprint $table) {
            $table->string('pekerjaan_ayah')->change();
            $table->string('pekerjaan_ibu')->change();
            $table->string('pekerjaan_wali')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('siswas', function (Blueprint $table) {
            $table->string('pekerjaan_ayah')->change();
            $table->string('pekerjaan_ibu')->change();
            $table->string('pekerjaan_wali')->nullable()->change();
        });
    }
};