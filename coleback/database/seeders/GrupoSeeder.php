<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GrupoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('grupos')->insert([
           ['nombre'=>'COMUNIDAD Y SOCIEDAD'],
            ['nombre'=>'CIENCIA, TECNOLOGIA Y PRODUCCIÓN '],
            ['nombre'=>'VIDA TIERRA TERRITORIO'],
            ['nombre'=>'COSMOS Y PENSAMIENTO '],
        ]);
    }
}
