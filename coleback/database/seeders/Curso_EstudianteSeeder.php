<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Curso_EstudianteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('curso_estudiante')->insert([
            [
                'estudiante_id'=>"1",
                'curso_id'=>"1",
                'periodo_id'=>"1",
                'user_id'=>"1"
            ]
        ]);
    }
}
