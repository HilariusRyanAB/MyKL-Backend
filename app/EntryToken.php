<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EntryToken extends Model
{
    protected $table = 'entry_token';
    protected $primaryKey = 'id_entry_token';
    public $timestamps = false;
    protected $fillable = [
        'id_user', 'entry_code', 'tanggal_pembuatan_token', 'status_token'
    ];
}
