<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CursoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("cursos")->insert([
            ["nombre"=>"PRIMERO A", "paralelo"=>"A"],
            ["nombre"=>"PRIMERO B", "paralelo"=>"B"],
            ["nombre"=>"PRIMERO C", "paralelo"=>"C"],
            ["nombre"=>"PRIMERO D", "paralelo"=>"D"],
            ["nombre"=>"SEGUNDO A", "paralelo"=>"A"],
            ["nombre"=>"SEGUNDO B", "paralelo"=>"B"],
            ["nombre"=>"SEGUNDO C", "paralelo"=>"C"],
            ["nombre"=>"SEGUNDO D", "paralelo"=>"D"],
            ["nombre"=>"TERCERO A", "paralelo"=>"A"],
            ["nombre"=>"TERCERO B", "paralelo"=>"B"],
            ["nombre"=>"TERCERO C", "paralelo"=>"C"],
            ["nombre"=>"TERCERO D", "paralelo"=>"D"],
            ["nombre"=>"CUARTO A", "paralelo"=>"A"],

        ]);
    }
}
