<?php

/*
 * This file is part of the IndoRegion package.
 *
 * (c) Azis Hapidin <azishapidin.com | azishapidin@gmail.com>
 *
 */

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use AzisHapidin\IndoRegion\RawDataGetter;
use Illuminate\Support\Facades\DB;

class IndoRegionSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Get Data
        $provinces = RawDataGetter::getProvinces();
        $regencies = RawDataGetter::getRegencies();
        $districts = RawDataGetter::getDistricts();
        $villages = RawDataGetter::getVillages();

        // Insert Data
        DB::table('provinces')->insert($provinces);
        DB::table('regencies')->insert($regencies);
        DB::table('districts')->insert($districts);
        DB::table('villages')->insert($villages);
    }
}
