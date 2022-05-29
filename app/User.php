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
    
    protected $table = 'user';
    protected $primaryKey = 'id_user';
    public $timestamps = false;
    protected $fillable = [
        'nama_user', 'role_user', 'alamat_user', 'nomor_telepon_user', 'password', 'status_user', 'email_user', 'fcm_token'
    ];

    protected $hidden = [
        'password'
    ];
}