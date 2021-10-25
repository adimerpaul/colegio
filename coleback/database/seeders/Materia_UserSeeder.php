<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Materia_UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('materia_user')->insert([
            [
                'materia_id'=>"1",
                'user_id'=>"3",
            ]
        ]);
    }
}
