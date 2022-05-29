<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WaterFacility extends Model
{
    protected $table = 'water_facility';
    protected $primaryKey = 'id_water_facility';
    public $timestamps = false;
    protected $fillable = [
        'id_properti', 'status_water_facility'
    ];
}
