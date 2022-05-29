<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CCTVAccess extends Model
{
    protected $table = 'cctv_access';
    protected $primaryKey = 'id_cctv_access';
    public $timestamps = false;
    protected $fillable = [
        'id_properti', 'link_cctv', 'status_cctv_access'
    ];
}
