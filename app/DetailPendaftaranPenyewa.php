<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailPendaftaranPenyewa extends Model
{
    protected $table = 'detail_pendaftaran_penyewa';
    protected $primaryKey = 'id_pendaftaran';
    public $timestamps = false;
    protected $fillable = [
        'id_pegawai', 'id_penyewa', 'tanggal_pendaftaran',
    ];
}
