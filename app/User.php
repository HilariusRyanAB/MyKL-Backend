<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Carbon\Carbon;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;
    
    protected $table = 'pegawai';
    protected $primaryKey = 'id_pegawai';
    public $timestamps = false;
    protected $fillable = [
        'nama_pegawai', 'role', 'jenis_kelamin', 'nomor_pegawai', 'password', 'status_pegawai', 'status_otoritas'
    ];

    protected $hidden = [
        'password'
    ];
}