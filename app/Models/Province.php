<?php

namespace App\Models;

use AzisHapidin\IndoRegion\Traits\ProvinceTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Province extends Model
{
    use ProvinceTrait;

    protected $table = 'provinces';

    protected $fillable = [
        'id',
        'name'
    ];

    public function regencies()
    {
        return $this->hasMany(Regency::class, 'province_id');
    }

    public function districts()
    {
        return $this->hasManyThrough(District::class, Regency::class, 'province_id', 'regency_id');
    }

    public function villages()
    {
        return $this->hasManyThrough(
            Village::class,
            District::class,
            'regency_id',
            'district_id'
        )->whereIn('districts.regency_id', function($query) {
            $query->select('id')
                ->from('regencies')
                ->where('province_id', $this->id);
        });
    }

    // Tambahkan method untuk menghitung villages
    public function getVillagesCountAttribute()
    {
        return Village::whereIn('district_id', function($query) {
            $query->select('districts.id')
                ->from('districts')
                ->join('regencies', 'districts.regency_id', '=', 'regencies.id')
                ->where('regencies.province_id', $this->id);
        })->count();
    }
}
