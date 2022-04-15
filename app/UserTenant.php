<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\UserTenant as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Carbon\Carbon;

class UserTenant extends Authenticatable
{
    use Notifiable, HasApiTokens;
    
    protected $table = 'penyewa';
    protected $primaryKey = 'id_penyewa';
    public $timestamps = false;
    protected $fillable = [
        'nama_penyewa', 'alamat_penyewa', 'nomor_telepon_penyewa', 'status_penyewa', 'email_penyewa',
    ];

    protected $hidden = [
        'password_penyewa'
    ];

    public function getReminderEmail()
    {
        return $this->email_penyewa;
    }

    public function getAuthPassword()
    {
        return $this->password_penyewa;
    }
}