<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HistoryKepemilikan extends Model
{
    protected $table = 'history_kepemilikan';
    protected $primaryKey = 'id_history_kepemilikan';
    public $timestamps = false;
    protected $fillable = [
        'id_properti', 'id_user', 'tanggal_mulai_kepemilikan', 'tanggal_berhenti_kepemilikan', 'status_kepemilikan'
    ];
}
