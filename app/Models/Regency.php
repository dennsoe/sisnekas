<?php

namespace App\Models;

use AzisHapidin\IndoRegion\Traits\RegencyTrait;
use Illuminate\Database\Eloquent\Model;

class Regency extends Model
{
    use RegencyTrait;

    protected $table = 'regencies';

    protected $fillable = [
        'id',
        'province_id',
        'name'
    ];
}
