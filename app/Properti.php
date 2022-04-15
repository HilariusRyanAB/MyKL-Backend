<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Properti extends Model
{
    protected $table = 'properti';
    protected $primaryKey = 'id_properti';
    public $timestamps = false;
    protected $fillable = [
        'nomor_kavling', 'luas_tanah', 'luas_bangunan', 'jumlah_denda', 'status_properti'
    ];
}
