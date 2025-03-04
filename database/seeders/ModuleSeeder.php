<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('modules')->insert([
            [
                'name' => 'Módulo de seguridad',
                'description' => 'Módulos de seguridad',
                'key' => 'seguridad',
                'audit_user_id' => 1,
                'created_at' => date('Y-m-d H:m:s')
            ],
        ]);
    }
}
