<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class DetailTenantRegisterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('detail_pendaftaran_penyewa')->insert([
            'tanggal_pendaftaran' => Carbon::parse('2021-07-10'), 
            'id_penyewa' => 1,
            'id_pemilik' => 3,
        ]);

        DB::table('detail_pendaftaran_penyewa')->insert([
            'tanggal_pendaftaran' => Carbon::parse('2021-08-05'), 
            'id_penyewa' => 2,
            'id_pemilik' => 2,
        ]);

        DB::table('detail_pendaftaran_penyewa')->insert([
            'tanggal_pendaftaran' => Carbon::parse('2021-09-18'), 
            'id_penyewa' => 3,
            'id_pemilik' => 4,
        ]);

        DB::table('detail_pendaftaran_penyewa')->insert([
            'tanggal_pendaftaran' => Carbon::parse('2021-09-20'), 
            'id_penyewa' => 4,
            'id_pemilik' => 5,
        ]);
    }
}
