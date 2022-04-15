<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class HistoryTenantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('history_penyewaan')->insert([
            'tanggal_mulai_penyewaan' => Carbon::parse('2021-07-15'),
            'tanggal_berhenti_penyewaan' => Carbon::parse('2021-12-15'), 
            'id_penyewa' => 1,
            'id_properti' => 9,
            'status_penyewaan' => 'Active'
        ]);

        DB::table('history_penyewaan')->insert([
            'tanggal_mulai_penyewaan' => Carbon::parse('2021-08-08'),
            'tanggal_berhenti_penyewaan' => Carbon::parse('2022-01-04'), 
            'id_penyewa' => 2,
            'id_properti' => 7,
            'status_penyewaan' => 'Inctive'
        ]);

        DB::table('history_penyewaan')->insert([
            'tanggal_mulai_penyewaan' => Carbon::parse('2021-09-20'),
            'tanggal_berhenti_penyewaan' => Carbon::parse('2022-03-20'), 
            'id_penyewa' => 3,
            'id_properti' => 1,
            'status_penyewaan' => 'Active'
        ]);

        DB::table('history_penyewaan')->insert([
            'tanggal_mulai_penyewaan' => Carbon::parse('2021-09-24'),
            'tanggal_berhenti_penyewaan' => Carbon::parse('2022-06-24'), 
            'id_penyewa' => 4,
            'id_properti' => 6,
            'status_penyewaan' => 'Active'
        ]);

        DB::table('history_penyewaan')->insert([
            'tanggal_mulai_penyewaan' => Carbon::parse('2022-01-10'),
            'tanggal_berhenti_penyewaan' => Carbon::parse('2022-07-10'), 
            'id_penyewa' => 2,
            'id_properti' => 8,
            'status_penyewaan' => 'Active'
        ]);

        DB::table('history_penyewaan')->insert([
            'tanggal_mulai_penyewaan' => Carbon::parse('2022-01-20'),
            'tanggal_berhenti_penyewaan' => Carbon::parse('2022-05-20'), 
            'id_penyewa' => 4,
            'id_properti' => 4,
            'status_penyewaan' => 'Active'
        ]);
    }
}
