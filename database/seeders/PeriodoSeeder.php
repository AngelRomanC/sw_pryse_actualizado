<?php

namespace Database\Seeders;

use App\Models\Periodo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PeriodoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Periodo::create(['periodo'=>'Sep-Dic','año'=>'2024','nomenclatura'=>'O2024']);
        Periodo::create(['periodo'=>'Ene-Abr','año'=>'2024','nomenclatura'=>'I2024']);
        Periodo::create(['periodo'=>'May-Ago','año'=>'2024','nomenclatura'=>'P2024']);

    }
}
