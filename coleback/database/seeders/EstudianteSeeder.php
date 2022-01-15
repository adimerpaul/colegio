<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstudianteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('estudiantes')->insert([
            [
                'carnet'=>'1010',
                'domicilio'=>'CALLE X',
                'paterno'=>'TANTACHUCO',
                'materno'=>'LIMACHI',
                'nombres'=>'ARON',
                'celular'=>'',
                'fechanac'=>'2000-01-01',
//                'curso'=>'PRIMERO A',
//                'tipo'=>'NUEVO',
//                'paralelo'=>'A',
                'fecha'=>'2021-10-25',
                'estado'=>'ACTIVO',
                'imagen'=>'user.png',
                'curso_id'=>1,
                'sexo'=>'M'
            ],
            [
                'carnet'=>'2020',
                'domicilio'=>'CALLE X',
                'paterno'=>'TANTACHUCO',
                'materno'=>'LIMACHI',
                'nombres'=>'ARIANA',
                'celular'=>'',
                'fechanac'=>'2000-01-01',
//                'curso'=>'PRIMERO A',
//                'tipo'=>'NUEVO',
//                'paralelo'=>'A',
                'fecha'=>'2021-10-25',
                'estado'=>'ACTIVO',
                'imagen'=>'user.png',
                'curso_id'=>1,
                'sexo'=>'M'
            ]
        ]);
    }
}
