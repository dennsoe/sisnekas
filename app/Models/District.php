<?php

namespace App\Models;

use AzisHapidin\IndoRegion\Traits\DistrictTrait;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use DistrictTrait;

    protected $table = 'districts';

    protected $fillable = [
        'id',
        'regency_id',
        'name'
    ];
}
