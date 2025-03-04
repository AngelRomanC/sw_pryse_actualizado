<?php

namespace Database\Seeders;

use App\Models\Grupo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GrupoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Grupo::create(['grado'=>'1','grupo'=>'A','profesor_id'=>'1','estatus'=>'0']);
        Grupo::create(['grado'=>'1','grupo'=>'B','profesor_id'=>'1','estatus'=>'0']);
        Grupo::create(['grado'=>'1','grupo'=>'C','profesor_id'=>'1','estatus'=>'0']);
        Grupo::create(['grado'=>'1','grupo'=>'D','profesor_id'=>'2','estatus'=>'0']);
        Grupo::create(['grado'=>'1','grupo'=>'E','profesor_id'=>'2','estatus'=>'0']);

    }
}
