<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('siswas', function (Blueprint $table) {
            $table->string('pekerjaan_ayah')->nullable()->change();
            $table->string('pekerjaan_ibu')->nullable()->change();
            $table->string('pekerjaan_wali')->nullable()->change();
            $table->string('penghasilan_ayah')->nullable()->change();
            $table->string('penghasilan_ibu')->nullable()->change();
            $table->string('penghasilan_wali')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('siswas', function (Blueprint $table) {
            $table->string('pekerjaan_ayah')->nullable(false)->change();
            $table->string('pekerjaan_ibu')->nullable(false)->change();
            $table->string('pekerjaan_wali')->nullable(false)->change();
            $table->string('penghasilan_ayah')->nullable(false)->change();
            $table->string('penghasilan_ibu')->nullable(false)->change();
            $table->string('penghasilan_wali')->nullable(false)->change();
        });
    }
};