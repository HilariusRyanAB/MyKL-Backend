<?php

use Illuminate\Database\Seeder;

class OwnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pemilik')->insert([
            'nama_pemilik' => 'Andi',
            'alamat_pemilik' => 'Jl. Soekarno 1', 
            'nomor_telepon_pemilik' => '085850580850',
            'email_pemilik' => 'andi@gmail.com',
            'password_pemilik' => '$2a$12$Pg2vfOQIoSM9uzgSybBVA.1wKJcG4WDBWbFI5/V35oeTTxNFWrNh2', 
            'status_pemilik' => 'Active'
        ]);

        DB::table('pemilik')->insert([
            'nama_pemilik' => 'Rahmat',
            'alamat_pemilik' => 'Jl. Soekarno 1', 
            'nomor_telepon_pemilik' => '085850580412',
            'email_pemilik' => 'rahmat@gmail.com',
            'password_pemilik' => '$2a$12$Pg2vfOQIoSM9uzgSybBVA.1wKJcG4WDBWbFI5/V35oeTTxNFWrNh2', 
            'status_pemilik' => 'Active'
        ]);

        DB::table('pemilik')->insert([
            'nama_pemilik' => 'Wahyu',
            'alamat_pemilik' => 'Jl. Soekarno 1', 
            'nomor_telepon_pemilik' => '085551280850',
            'email_pemilik' => 'wahyu@gmail.com',
            'password_pemilik' => '$2a$12$Pg2vfOQIoSM9uzgSybBVA.1wKJcG4WDBWbFI5/V35oeTTxNFWrNh2', 
            'status_pemilik' => 'Active'
        ]);

        DB::table('pemilik')->insert([
            'nama_pemilik' => 'Linda',
            'alamat_pemilik' => 'Jl. Soekarno 1', 
            'nomor_telepon_pemilik' => '08585051478',
            'email_pemilik' => 'linda@gmail.com',
            'password_pemilik' => '$2a$12$Pg2vfOQIoSM9uzgSybBVA.1wKJcG4WDBWbFI5/V35oeTTxNFWrNh2', 
            'status_pemilik' => 'Active'
        ]);

        DB::table('pemilik')->insert([
            'nama_pemilik' => 'Siti',
            'alamat_pemilik' => 'Jl. Soekarno 1', 
            'nomor_telepon_pemilik' => '085852071251',
            'email_pemilik' => 'siti@gmail.com',
            'password_pemilik' => '$2a$12$Pg2vfOQIoSM9uzgSybBVA.1wKJcG4WDBWbFI5/V35oeTTxNFWrNh2', 
            'status_pemilik' => 'Active'
        ]);
    }
}
