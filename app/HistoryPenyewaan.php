<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HistoryPenyewaan extends Model
{
    protected $table = 'history_penyewaan';
    protected $primaryKey = 'id_history_penyewaan';
    public $timestamps = false;
    protected $fillable = [
        'id_properti', 'id_penyewa', 'tanggal_mulai_penyewaan', 'tanggal_berhenti_penyewaan', 'status_penyewaan'
    ];
}
