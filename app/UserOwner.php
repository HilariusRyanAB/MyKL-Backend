<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\UserOwner as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Carbon\Carbon;

class UserOwner extends Authenticatable
{
    use Notifiable, HasApiTokens;
    
    protected $table = 'pemilik';
    protected $primaryKey = 'id_pemilik';
    public $timestamps = false;
    protected $fillable = [
        'nama_pemilik', 'alamat_pemilik', 'nomor_telepon_pemilik', 'status_pemilik', 'email_pemilik',
    ];

    protected $hidden = [
        'password_pemilik'
    ];

    public function getReminderEmail()
    {
        return $this->email_pemilik;
    }

    public function getAuthPassword()
    {
        return $this->password_pemilik;
    }
}