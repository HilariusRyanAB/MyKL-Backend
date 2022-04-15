<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Billing extends Model
{
    protected $table = 'billing';
    protected $primaryKey = 'id_billing';
    public $timestamps = false;
    protected $fillable = [
        'id_properti', 'tanggal_pembuatan_billing', 'nomor_billing', 'biaya_kotor', 'total_pajak', 'total_biaya', 'status_billing'
    ];
}
