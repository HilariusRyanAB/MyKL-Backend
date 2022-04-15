<?php

use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('role')->insert([
            'nama_role' => 'Operator'
        ]);

        DB::table('role')->insert([
            'nama_role' => 'Supervisor'
        ]);

        DB::table('role')->insert([
            'nama_role' => 'Manager'
        ]);
    }
}
