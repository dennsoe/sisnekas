<?php

namespace App\Data;

use App\Models\Regency;
use App\Models\District;

class KecamatanData
{
    public static function getKecamatanByKabupatenKota(string $kabupatenKota): array
    {
        $regency = Regency::where('name', 'LIKE', "%$kabupatenKota%")->first();
        if (!$regency) return [];

        return District::where('regency_id', $regency->id)
            ->pluck('name')
            ->map(fn($name) => strtoupper($name))
            ->toArray();
    }

    public static function getKecamatanOptions(string $kabupatenKota): array
    {
        $kecamatan = self::getKecamatanByKabupatenKota($kabupatenKota);
        return array_combine(
            array_map('strtoupper', $kecamatan),
            array_map('strtoupper', $kecamatan)
        );
    }
}
