<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InternetAccess extends Model
{
    protected $table = 'internet_access';
    protected $primaryKey = 'id_internet_access';
    public $timestamps = false;
    protected $fillable = [
        'id_user', 'id_properti', 'ip_address_user', 'status_internet_access'
    ];
}
