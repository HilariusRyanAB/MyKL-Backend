<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class HistoryOwnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('history_kepemilikan')->insert([
            'tanggal_mulai_kepemilikan' => Carbon::parse('2021-06-01'),
            'tanggal_berhenti_kepemilikan' => Carbon::parse('2022-01-01'), 
            'id_pemilik' => 1,
            'id_properti' => 5,
            'status_kepemilikan' => 'Inactive'
        ]);

        DB::table('history_kepemilikan')->insert([
            'tanggal_mulai_kepemilikan' => Carbon::parse('2021-06-01'),
            'tanggal_berhenti_kepemilikan' => Carbon::parse('2022-11-01'), 
            'id_pemilik' => 1,
            'id_properti' => 3,
            'status_kepemilikan' => 'Active'
        ]);

        DB::table('history_kepemilikan')->insert([
            'tanggal_mulai_kepemilikan' => Carbon::parse('2021-06-05'),
            'tanggal_berhenti_kepemilikan' => Carbon::parse('2022-06-05'), 
            'id_pemilik' => 2,
            'id_properti' => 2,
            'status_kepemilikan' => 'Active'
        ]);

        DB::table('history_kepemilikan')->insert([
            'tanggal_mulai_kepemilikan' => Carbon::parse('2021-07-02'),
            'tanggal_berhenti_kepemilikan' => Carbon::parse('2022-07-02'), 
            'id_pemilik' => 3,
            'id_properti' => 9,
            'status_kepemilikan' => 'Active'
        ]);

        DB::table('history_kepemilikan')->insert([
            'tanggal_mulai_kepemilikan' => Carbon::parse('2021-07-05'),
            'tanggal_berhenti_kepemilikan' => Carbon::parse('2022-01-05'), 
            'id_pemilik' => 2,
            'id_properti' => 7,
            'status_kepemilikan' => 'Inactive'
        ]);

        DB::table('history_kepemilikan')->insert([
            'tanggal_mulai_kepemilikan' => Carbon::parse('2021-07-10'),
            'tanggal_berhenti_kepemilikan' => Carbon::parse('2022-07-10'), 
            'id_pemilik' => 4,
            'id_properti' => 1,
            'status_kepemilikan' => 'Active'
        ]);

        DB::table('history_kepemilikan')->insert([
            'tanggal_mulai_kepemilikan' => Carbon::parse('2021-08-14'),
            'tanggal_berhenti_kepemilikan' => Carbon::parse('2023-02-14'), 
            'id_pemilik' => 5,
            'id_properti' => 6,
            'status_kepemilikan' => 'Active'
        ]);

        DB::table('history_kepemilikan')->insert([
            'tanggal_mulai_kepemilikan' => Carbon::parse('2021-10-11'),
            'tanggal_berhenti_kepemilikan' => Carbon::parse('2022-10-11'), 
            'id_pemilik' => 5,
            'id_properti' => 4,
            'status_kepemilikan' => 'Active'
        ]);

        DB::table('history_kepemilikan')->insert([
            'tanggal_mulai_kepemilikan' => Carbon::parse('2021-12-05'),
            'tanggal_berhenti_kepemilikan' => Carbon::parse('2023-02-10'), 
            'id_pemilik' => 1,
            'id_properti' => 8,
            'status_kepemilikan' => 'Active'
        ]);
    }
}
