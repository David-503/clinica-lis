<?php

use Illuminate\Database\Seeder;
use \Illuminate\Support\Facades\DB;

class TypesUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('type_users')->insert([
            'type' => 'Administrador'
        ]);

        DB::table('type_users')->insert([
            'type' => 'Doctor'
        ]);

        DB::table('type_users')->insert([
            'type' => 'Promotor'
        ]);

        DB::table('type_users')->insert([
            'type' => 'Secretaria'
        ]);

        DB::table('type_users')->insert([
            'type' => 'Paciente'
        ]);
    }
}
