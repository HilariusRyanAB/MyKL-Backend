<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Penyewa extends Model
{
    protected $table = 'penyewa';
    public $timestamps = false;
    protected $primaryKey = 'id_penyewa';
    protected $fillable = [
        'nama_penyewa', 'alamat_penyewa', 'nomor_telepon_penyewa', 'status_penyewa', 'email_penyewa', 'password_penyewa',
    ];
}
