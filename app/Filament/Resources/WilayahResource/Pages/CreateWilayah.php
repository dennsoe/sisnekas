<?php

namespace App\Filament\Resources\WilayahResource\Pages;

use App\Filament\Resources\WilayahResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Models\Province;
use App\Models\Regency;
use App\Models\District;
use App\Models\Village;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;

class CreateWilayah extends CreateRecord
{
    protected static string $resource = WilayahResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        Log::info('Form data received:', $data);

        // Handle Provinsi
        if (!empty($data['province_code']) && !empty($data['province_name'])) {
            return Province::create([
                'id' => $data['province_code'],
                'name' => $data['province_name'],
            ]);
        }

        // Handle Kabupaten/Kota
        if (!empty($data['regency_code']) && !empty($data['regency_name'])) {
            return Regency::create([
                'id' => $data['regency_code'],
                'province_id' => $data['province_id'],
                'name' => $data['regency_name'],
            ]);
        }

        // Handle Kecamatan
        if (!empty($data['district_code']) && !empty($data['district_name'])) {
            return District::create([
                'id' => $data['district_code'],
                'regency_id' => $data['regency_id_district'],
                'name' => $data['district_name'],
            ]);
        }

        // Handle Desa/Kelurahan
        if (!empty($data['village_code']) && !empty($data['village_name'])) {
            return Village::create([
                'id' => $data['village_code'],
                'district_id' => $data['district_id_village'],
                'name' => $data['village_name'],
            ]);
        }

        throw new \Exception('Silakan isi minimal satu data wilayah (Provinsi/Kabupaten/Kecamatan/Desa)');
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
