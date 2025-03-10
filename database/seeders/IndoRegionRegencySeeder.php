<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use AzisHapidin\IndoRegion\RawDataGetter;
use Illuminate\Support\Facades\DB;

class IndoRegionRegencySeeder extends Seeder
{
    public function run()
    {
        // Get Data
        $regencies = RawDataGetter::getRegencies();

        // Insert Data to Database
        DB::table('regencies')->insert($regencies);
    }
}
