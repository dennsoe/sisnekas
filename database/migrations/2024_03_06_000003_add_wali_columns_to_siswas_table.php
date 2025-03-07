<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('siswas', function (Blueprint $table) {
            $table->string('nama_wali')->nullable()->after('penghasilan_ibu');
            $table->string('nik_wali', 16)->nullable()->after('nama_wali');
            $table->string('tempat_lahir_wali')->nullable()->after('nik_wali');
            $table->date('tanggal_lahir_wali')->nullable()->after('tempat_lahir_wali');
            $table->string('pendidikan_wali')->nullable()->after('tanggal_lahir_wali');
            $table->string('pekerjaan_wali')->nullable()->after('pendidikan_wali');
            $table->string('penghasilan_wali')->nullable()->after('pekerjaan_wali');
        });
    }

    public function down(): void
    {
        Schema::table('siswas', function (Blueprint $table) {
            $table->dropColumn([
                'nama_wali',
                'nik_wali',
                'tempat_lahir_wali',
                'tanggal_lahir_wali',
                'pendidikan_wali',
                'pekerjaan_wali',
                'penghasilan_wali'
            ]);
        });
    }
};