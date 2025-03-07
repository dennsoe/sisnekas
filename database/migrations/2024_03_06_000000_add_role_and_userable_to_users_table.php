<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->after('password')->default('user');
            $table->unsignedBigInteger('userable_id')->after('role')->nullable();
            $table->string('userable_type')->after('userable_id')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'userable_id', 'userable_type']);
        });
    }
};