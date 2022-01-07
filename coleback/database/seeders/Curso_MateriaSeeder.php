<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Curso_MateriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('curso_materia')->insert([
            [
                'materia_id'=>"1",
                'curso_id'=>"1",
                'periodo_id'=>"1",
                "profesor_id"=>"4"
            ]
        ]);
    }
}
