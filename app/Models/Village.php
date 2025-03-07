<?php

namespace App\Models;

use AzisHapidin\IndoRegion\Traits\VillageTrait;
use Illuminate\Database\Eloquent\Model;

class Village extends Model
{
    use VillageTrait;

    protected $table = 'villages';

    protected $fillable = [
        'id',
        'district_id',
        'name'
    ];

    public function district()
    {
        return $this->belongsTo(District::class);
    }
}
