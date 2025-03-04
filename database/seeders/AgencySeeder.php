<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AgencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('agencies')->insert([
            [
                'name' => 'ZONA JOJUTLA',
                'description' => 'Municipio de Jojutla',
                'created_at' => date('Y-m-d H:m:s')
            ],
            [
                'name' => 'ZONA JIUTEPEC',
                'description' => 'Municipio de Jiutepec',
                'created_at' => date('Y-m-d H:m:s')
            ],
            [
                'name' => '	ZONA ATLACOMULCO',
                'description' => 'Municipio de Atlacomulco',
                'created_at' => date('Y-m-d H:m:s')
            ],
            [
                'name' => 'ZACATEPEC',
                'description' => 'Municipio de Zacatepec',
                'created_at' => date('Y-m-d H:m:s')
            ],
        ]);
    }
}
