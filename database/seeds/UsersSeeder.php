<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'dui' => '06080515-1',
            'name' => 'José Roberto',
            'lastname' => 'Cruz González',
            'email' => 'cruzt6869@gmail.com',
            'address' => 'Las Margaritas, Soyapango',
            'gender' => '1',
            'password' => bcrypt('12345678'),
            'birthdate' => '2000/08/27',
            'id_type_user' => 1
        ]);

        DB::table('users')->insert([
            'dui' => '43572093-2',
            'name' => 'Michelle Alejandra',
            'lastname' => 'Hernandez Ayala',
            'email' => 'michelleAlejandra@gmail.com',
            'address' => 'Su casa',
            'gender' => '0',
            'password' => bcrypt('12345678'),
            'birthdate' => '2000/08/27',
            'id_type_user' => 5
        ]);

        DB::table('users')->insert([
            'dui' => '10647389-2',
            'name' => 'Vanessa Andrade',
            'lastname' => 'Martinez Alvarado',
            'email' => 'vanessaAndrade@gmail.com',
            'address' => 'Su casa',
            'gender' => '0',
            'password' => bcrypt('12345678'),
            'birthdate' => '2000/08/27',
            'id_type_user' => 5
        ]);

        DB::table('users')->insert([
            'dui' => '56710921-3',
            'name' => 'Bryan Walberto',
            'lastname' => 'Garay Alvarado',
            'email' => 'garayAlvarado@gmail.com',
            'address' => 'Su casa',
            'gender' => '1',
            'password' => bcrypt('12345678'),
            'birthdate' => '2000/08/27',
            'id_type_user' => 2
        ]);
    }
}
