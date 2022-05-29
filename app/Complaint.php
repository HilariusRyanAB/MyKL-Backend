<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    protected $table = 'complaint';
    protected $primaryKey = 'id_complaint';
    public $timestamps = false;
    protected $fillable = [
        'id_user', 'id_properti', 'tanggal_complaint', 'topic_complaint', 'detail_complaint', 'status_complaint'
    ];
}
