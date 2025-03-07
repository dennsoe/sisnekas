<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use AzisHapidin\IndoRegion\RawDataGetter;
use Illuminate\Support\Facades\DB;

class IndoRegionDistrictSeeder extends Seeder
{
    public function run()
    {
        // Get Data
        $districts = RawDataGetter::getDistricts();

        // Insert Data to Database
        DB::table('districts')->insert($districts);
    }
}
