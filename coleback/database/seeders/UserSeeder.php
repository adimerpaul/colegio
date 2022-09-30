<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
//            ['tipo'=>'USUARIO','name'=>'ADMINISTRADOR','carnet'=>'1111','email'=>'admin@test.com','password'=>Hash::make('admin'),'fechalimite'=>'9999/01/01','unit_id'=>1],
//            ['tipo'=>'USUARIO','name'=>'ADIMER PAUL CHAMBI AJATA','carnet'=>'1010','email'=>'a@gmail.com','password'=>Hash::make('1010'),'fechalimite'=>'9999/01/01','unit_id'=>1],
//            ['tipo'=>'USUARIO','name'=>'ALEJANDRO LOPEZ','carnet'=>'2020','email'=>'b@gmail.com','password'=>Hash::make('2020'),'fechalimite'=>'9999/01/01','unit_id'=>2],
//            ['tipo'=>'USUARIO','name'=>'GERMAN','carnet'=>'3030','email'=>'c@gmail.com','password'=>Hash::make('3030'),'fechalimite'=>'9999/01/01','unit_id'=>3],
        [
            'tipo'=>'ADMINISTRADOR',
            'nombres'=>'Administrador',
            'apellidos'=>'Administrador',
            'carnet'=>'111111',
            'expedido'=>'OR',
            'fechanac'=>'2021-01-01',
            'email'=>'admin@test.com',
            'fechalimite'=>'9999-01-01',
            'password'=>Hash::make('admin'),
        ],
            [
                'tipo'=>'PADRE',
                'nombres'=>'CARLOS',
                'apellidos'=>'TANTACHUCO LIMA',
                'carnet'=>'222222',
                'expedido'=>'OR',
                'fechanac'=>'2021-01-01',
                'email'=>'carlos@santarosa.com',
                'fechalimite'=>'9999-01-01',
                'password'=>Hash::make('123456'),
            ],
            [
                'tipo'=>'PADRE',
                'nombres'=>'MARIA',
                'apellidos'=>'CALLE LOPEZ',
                'carnet'=>'222222',
                'expedido'=>'OR',
                'fechanac'=>'2021-01-01',
                'email'=>'maria@santarosa.com',
                'fechalimite'=>'9999-01-01',
                'password'=>Hash::make('123456'),
            ],
            [
                'tipo'=>'PROFESOR',
                'nombres'=>'AMILCAR',
                'apellidos'=>'QUISPAYA LIMA',
                'carnet'=>'333333',
                'expedido'=>'OR',
                'fechanac'=>'2021-01-01',
                'email'=>'a@santarosa.com',
                'fechalimite'=>'9999-01-01',
                'password'=>Hash::make('123456'),
            ],
        ]);
    }
}
