<?php

use Illuminate\Database\Seeder;

class TenantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('penyewa')->insert([
            'nama_penyewa' => 'Rahayu',
            'alamat_penyewa' => 'Jl. Kaliurang 18', 
            'nomor_telepon_penyewa' => '081581285650',
            'email_penyewa' => 'rahayu@gmail.com',
            'password_penyewa' => '$2a$12$Pg2vfOQIoSM9uzgSybBVA.1wKJcG4WDBWbFI5/V35oeTTxNFWrNh2', 
            'status_penyewa' => 'Active'
        ]);

        DB::table('penyewa')->insert([
            'nama_penyewa' => 'Budi',
            'alamat_penyewa' => 'Jl. Pepaya 10', 
            'nomor_telepon_penyewa' => '081581241650',
            'email_penyewa' => 'budi@gmail.com',
            'password_penyewa' => '$2a$12$Pg2vfOQIoSM9uzgSybBVA.1wKJcG4WDBWbFI5/V35oeTTxNFWrNh2', 
            'status_penyewa' => 'Active'
        ]);

        DB::table('penyewa')->insert([
            'nama_penyewa' => 'Surya',
            'alamat_penyewa' => 'Jl. Semangka 27', 
            'nomor_telepon_penyewa' => '081241565650',
            'email_penyewa' => 'surya@gmail.com',
            'password_penyewa' => '$2a$12$Pg2vfOQIoSM9uzgSybBVA.1wKJcG4WDBWbFI5/V35oeTTxNFWrNh2', 
            'status_penyewa' => 'Active'
        ]);

        DB::table('penyewa')->insert([
            'nama_penyewa' => 'Wati',
            'alamat_penyewa' => 'Jl. Mangga 16', 
            'nomor_telepon_penyewa' => '081681516820',
            'email_penyewa' => 'wati@gmail.com',
            'password_penyewa' => '$2a$12$Pg2vfOQIoSM9uzgSybBVA.1wKJcG4WDBWbFI5/V35oeTTxNFWrNh2', 
            'status_penyewa' => 'Active'
        ]);
    }
}
