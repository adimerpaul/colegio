<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NotaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('notas')->insert([
            [
                'materia_id'=>"1",
                'curso_id'=>"1",
                'user_id'=>"3",
                'periodo_id'=>"1",
                'estudiante_id'=>"1",
                'promedio'=>"51",
                'trimestre'=>"PRIMER TRIMESTRE",
                'fecha'=>"2021-10-25",
                'hora'=>"10:00",
            ],
            [
                'materia_id'=>"1",
                'curso_id'=>"1",
                'user_id'=>"3",
                'periodo_id'=>"1",
                'estudiante_id'=>"2",
                'promedio'=>"51",
                'trimestre'=>"PRIMER TRIMESTRE",
                'fecha'=>"2021-10-25",
                'hora'=>"10:00",
            ],
        ]);
    }
}
