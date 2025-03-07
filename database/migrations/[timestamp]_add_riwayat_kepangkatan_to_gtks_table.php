<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('gtks', function (Blueprint $table) {
            $table->json('riwayat_kepangkatan')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('gtks', function (Blueprint $table) {
            $table->dropColumn('riwayat_kepangkatan');
        });
    }
};