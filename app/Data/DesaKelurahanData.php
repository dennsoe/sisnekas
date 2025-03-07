<?php

namespace App\Data;

use App\Models\District;
use App\Models\Village;

class DesaKelurahanData
{
    public static function getDesaKelurahanByKecamatan(string $kecamatan): array
    {
        $district = District::where('name', 'LIKE', "%$kecamatan%")->first();
        if (!$district) return [];

        return Village::where('district_id', $district->id)
            ->pluck('name')
            ->map(fn($name) => strtoupper($name))
            ->toArray();
    }

    public static function getDesaKelurahanOptions(string $kecamatan): array
    {
        $desaKelurahan = self::getDesaKelurahanByKecamatan($kecamatan);
        return array_combine(
            array_map('strtoupper', $desaKelurahan),
            array_map('strtoupper', $desaKelurahan)
        );
    }
}
