<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermisoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permisos')->insert([
            ["id"=>1,"nombre"=>'Gestionar Usuarios'],
            ["id"=>2,"nombre"=>'Gestionar profesores'],
            ["id"=>3,"nombre"=>'Gestionar cursos'],
            ["id"=>4,"nombre"=>'Gestionar materias'],
            ["id"=>5,"nombre"=>'Gestionar biblioteca'],
            ["id"=>6,"nombre"=>'Registro de calificaiones'],
            ["id"=>7,"nombre"=>'Gestionar gestiones'],
            ["id"=>8,"nombre"=>'Inscribir estudiante'],
            ["id"=>9,"nombre"=>'Informe inscritos'],
            ["id"=>10,"nombre"=>'Gestionar calificaciones'],
        ]);
    }
}
