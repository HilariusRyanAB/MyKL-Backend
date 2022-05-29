<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Denda extends Model
{
    protected $table = 'denda';
    protected $primaryKey = 'id_denda';
    public $timestamps = false;
    protected $fillable = [
        'id_billing', 'tanggal_denda', 'total_denda', 'status_denda'
    ];
}