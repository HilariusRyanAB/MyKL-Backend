<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class DetailBillingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('detail_pembayaran_billing')->insert([
            'tanggal_pembayaran' => Carbon::now(), 
            'metode_pembayaran' => 'NFC',
            'id_billing' => 1,
            'id_penyewa' => 3,
        ]);

        DB::table('detail_pembayaran_billing')->insert([
            'tanggal_pembayaran' => Carbon::now(),
            'metode_pembayaran' => 'NFC',
            'id_billing' => 2,
            'id_pemilik' => 2,
        ]);

        DB::table('detail_pembayaran_billing')->insert([
            'tanggal_pembayaran' => Carbon::now(),
            'metode_pembayaran' => 'Transfer',
            'id_billing' => 3,
            'id_pemilik' => 1,
        ]);

        DB::table('detail_pembayaran_billing')->insert([
            'tanggal_pembayaran' => Carbon::now(),
            'metode_pembayaran' => 'NFC',
            'id_billing' => 4,
            'id_penyewa' => 4,
        ]);

        DB::table('detail_pembayaran_billing')->insert([
            'tanggal_pembayaran' => Carbon::now(),
            'metode_pembayaran' => 'NFC',
            'id_billing' => 5,
            'id_penyewa' => 4,
        ]);

        DB::table('detail_pembayaran_billing')->insert([
            'tanggal_pembayaran' => Carbon::now(),
            'metode_pembayaran' => 'Transfer',
            'id_billing' => 6,
            'id_penyewa' => 2,
        ]);

        DB::table('detail_pembayaran_billing')->insert([
            'tanggal_pembayaran' => Carbon::now(),
            'metode_pembayaran' => 'NFC',
            'id_billing' => 7,
            'id_penyewa' => 1,
        ]);
    }
}
