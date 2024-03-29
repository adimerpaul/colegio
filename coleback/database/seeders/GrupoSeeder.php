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
           ['nombre'=>'COMUNIDAD Y SOCIEDAD',"color"=>"green-9"],
            ['nombre'=>'CIENCIA, TECNOLOGIA Y PRODUCCIÓN ',"color"=>"deep-purple-9"],
            ['nombre'=>'VIDA TIERRA TERRITORIO',"color"=>"deep-orange-9"],
            ['nombre'=>'COSMOS Y PENSAMIENTO ',"color"=>"pink-9"],
        ]);
    }
}
