<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProvincesTables extends Migration
{
    public function up()
    {
        Schema::create('provinces', function(Blueprint $table){
            $table->char('id', 2)->index();
            $table->string('name');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('provinces');
    }
}
