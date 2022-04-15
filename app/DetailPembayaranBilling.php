<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailPembayaranBilling extends Model
{
    protected $table = 'detail_pembayaran_billing';
    protected $primaryKey = 'id_detail_pembayaran';
    public $timestamps = false;
    protected $fillable = [
        'id_billing', 'tanggal_pembayaran', 'total_bayar', 'id_pemilik', 'id_penyewa'
    ];
}
