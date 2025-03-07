<?php

namespace App\Data;

use App\Models\Province;
use App\Models\Regency;

class KabupatenKotaData
{
    public static function getKabupatenKotaByProvinsi(string $provinsi): array
    {
        $province = Province::where('name', 'LIKE', "%$provinsi%")->first();
        if (!$province) return [];

        return Regency::where('province_id', $province->id)
            ->pluck('name')
            ->map(fn($name) => strtoupper($name))
            ->toArray();
    }

    public static function getKabupatenKotaOptions(string $provinsi): array
    {
        $kabupatenKota = self::getKabupatenKotaByProvinsi($provinsi);
        return array_combine(
            array_map('strtoupper', $kabupatenKota),
            array_map('strtoupper', $kabupatenKota)
        );
    }
}
