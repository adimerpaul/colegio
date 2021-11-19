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
            ["nombre"=>"PRIMERO", "paralelo"=>"A"],
            ["nombre"=>"PRIMERO", "paralelo"=>"B"],
//            ["nombre"=>"PRIMERO C", "paralelo"=>"C"],
//            ["nombre"=>"PRIMERO D", "paralelo"=>"D"],
            ["nombre"=>"SEGUNDO", "paralelo"=>"A"],
            ["nombre"=>"SEGUNDO", "paralelo"=>"B"],
//            ["nombre"=>"SEGUNDO C", "paralelo"=>"C"],
//            ["nombre"=>"SEGUNDO D", "paralelo"=>"D"],
            ["nombre"=>"TERCERO", "paralelo"=>"A"],
            ["nombre"=>"TERCERO", "paralelo"=>"B"],
//            ["nombre"=>"TERCERO C", "paralelo"=>"C"],
//            ["nombre"=>"TERCERO D", "paralelo"=>"D"],
            ["nombre"=>"CUARTO", "paralelo"=>"A"],
            ["nombre"=>"CUARTO", "paralelo"=>"B"],

        ]);
    }
}
