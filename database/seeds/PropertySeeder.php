<?php

use Illuminate\Database\Seeder;

class PropertySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('properti')->insert([
            'nomor_kavling' => 'A1-01',
            'luas_tanah' => 432, 
            'luas_bangunan' => 476,
            'jumlah_denda' => 0,
            'status_properti' => 'Active'
        ]);

        DB::table('properti')->insert([
            'nomor_kavling' => 'A1-02',
            'luas_tanah' => 135, 
            'luas_bangunan' => 216,
            'jumlah_denda' => 0,
            'status_properti' => 'Active'
        ]);

        DB::table('properti')->insert([
            'nomor_kavling' => 'A2-01',
            'luas_tanah' => 405, 
            'luas_bangunan' => 476,
            'jumlah_denda' => 0,
            'status_properti' => 'Active'
        ]);

        DB::table('properti')->insert([
            'nomor_kavling' => 'B1-01',
            'luas_tanah' => 260, 
            'luas_bangunan' => 200,
            'jumlah_denda' => 0,
            'status_properti' => 'Active'
        ]);

        DB::table('properti')->insert([
            'nomor_kavling' => 'B1-02',
            'luas_tanah' => 260, 
            'luas_bangunan' => 200,
            'jumlah_denda' => 0,
            'status_properti' => 'Inactive'
        ]);

        DB::table('properti')->insert([
            'nomor_kavling' => 'B2-01',
            'luas_tanah' => 304, 
            'luas_bangunan' => 240,
            'jumlah_denda' => 0,
            'status_properti' => 'Active'
        ]);

        DB::table('properti')->insert([
            'nomor_kavling' => 'C-01',
            'luas_tanah' => 1206, 
            'luas_bangunan' => 1030,
            'jumlah_denda' => 0,
            'status_properti' => 'Inactive'
        ]);

        DB::table('properti')->insert([
            'nomor_kavling' => 'C-05',
            'luas_tanah' => 888, 
            'luas_bangunan' => 720,
            'jumlah_denda' => 0,
            'status_properti' => 'Active'
        ]);

        DB::table('properti')->insert([
            'nomor_kavling' => 'D-01',
            'luas_tanah' => 319, 
            'luas_bangunan' => 258,
            'jumlah_denda' => 0,
            'status_properti' => 'Active'
        ]);

        DB::table('properti')->insert([
            'nomor_kavling' => 'D-02',
            'luas_tanah' => 288, 
            'luas_bangunan' => 216,
            'jumlah_denda' => 0,
            'status_properti' => 'Inactive'
        ]);
    }
}
