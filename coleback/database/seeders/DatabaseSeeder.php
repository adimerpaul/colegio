<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            UnitSeeder::class,
            UserSeeder::class,
            PermisoSeeder::class,
            PermisoUserSeeder::class,
            PeriodoSeeder::class,
            EstudianteSeeder::class,
            Estudiante_UserSeeder::class,
            CursoSeeder::class,
            GrupoSeeder::class,
            MateriaSeeder::class,
            Curso_MateriaSeeder::class,
            Materia_UserSeeder::class,
            NotaSeeder::class,
        ]);
    }
}
