<?php

namespace App\Data;

use App\Models\Province;

class ProvinsiData
{
    public static function getProvinsi(): array
    {
        return Province::pluck('name')
            ->map(fn($name) => strtoupper($name))
            ->toArray();
    }

    public static function getProvinsiOptions(): array
    {
        return Province::pluck('name', 'name')
            ->map(fn($name) => strtoupper($name))
            ->toArray();
    }
}
