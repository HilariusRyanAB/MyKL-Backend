<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pemilik extends Model
{
    protected $table = 'pemilik';
    protected $primaryKey = 'id_pemilik';
    public $timestamps = false;
    protected $fillable = [
        'nama_pemilik', 'alamat_pemilik', 'nomor_telepon_pemilik', 'status_pemilik', 'email_pemilik', 'password_pemilik',
    ];
}
