<?php

use Illuminate\Database\Seeder;

class PegawaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pegawai')->insert([
            'id_role' => '1',
            'nama_pegawai' => 'Hilarius', 
            'nomor_pegawai' => '0001', 
            'password' => '$2y$12$09/ZBhqUORzt27g0KEJ/b.FdzU17PVHYAnnMOGQUEbtM8sXOFFuz.', 
            'status_pegawai' => 'Active'
        ]);

        DB::table('pegawai')->insert([
            'id_role' => '2',
            'nama_pegawai' => 'Ryan', 
            'nomor_pegawai' => '0002', 
            'password' => '$2y$12$/yiwLvdsOl6YgDR3pkIaf.gikOdK1AawlWFcu0dkNwFeUQuc.asGO', 
            'status_pegawai' => 'Active'
        ]);

        DB::table('pegawai')->insert([
            'id_role' => '3',
            'nama_pegawai' => 'Auxilio', 
            'nomor_pegawai' => '0003', 
            'password' => '$2y$12$b5xHA2GYx5EnDK5CILhT7ujxdemYBhXoTzaWEQbPdEDRFViXxcKe.', 
            'status_pegawai' => 'Active'
        ]);
    }
}
