<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Estudiante_UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('estudiante_user')->insert([
            ['user_id'=>2, 'estudiante_id'=>1,"relacion"=>"PADRE"],
            ['user_id'=>2, 'estudiante_id'=>2,"relacion"=>"PADRE"],
        ]);
    }
}
