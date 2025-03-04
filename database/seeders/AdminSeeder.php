<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert(['name' => 'Santiago', 'apellido_paterno' => 'Heras', 'apellido_materno' => 'Gomez','numero' => '7775420768', 'email' => 'admin@gmail.com', 'email_verified_at' => '2024-01-17 04:50:32', 'password' => Hash::make('Password'), 'role' =>'Admin']);
        DB::table('users')->insert(['name' => 'Miguel', 'apellido_paterno' => 'roman', 'apellido_materno' => 'Chano','numero' => '7772052238', 'email' => 'miguel@gmail.com', 'email_verified_at' => '2024-01-17 04:50:32', 'password' => Hash::make('Password'), 'role' =>'Alumno']);
        DB::table('users')->insert(['name' => 'Juan paulo', 'apellido_paterno' => 'Sanchez', 'apellido_materno' => 'Hernandez','numero' => '7772054338', 'email' => 'juanpaulo@gmail.com', 'email_verified_at' => '2024-01-17 04:50:32', 'password' => Hash::make('Password'), 'role' =>'Tutor']);
        DB::table('users')->insert(['name' => 'Deny Lizbeth', 'apellido_paterno' => 'Hernandez', 'apellido_materno' => 'Rabadan','numero' => '7772054338', 'email' => 'deny@gmail.com', 'email_verified_at' => '2024-01-17 04:50:32', 'password' => Hash::make('Password'), 'role' =>'Tutor']);
        DB::table('users')->insert(['name' => 'José Santiago', 'apellido_paterno' => 'Heras', 'apellido_materno' => 'Gómez','numero' => '7775420768', 'email' => 'santiheras09@gmail.com', 'email_verified_at' => '2024-01-17 04:50:32', 'password' => Hash::make('Password'), 'role' =>'Alumno']);

        $user1 = User::where('email', 'admin@gmail.com')->first();$user1->assignRole('Admin');
        $user2 = User::where('email', 'miguel@gmail.com')->first(); $user2->assignRole('Alumno');
        $user3 = User::where('email', 'juanpaulo@gmail.com')->first();$user3->assignRole('Tutor');
        $user4 = User::where('email', 'deny@gmail.com')->first();$user4->assignRole('Tutor');
        $user5 = User::where('email', 'santiheras09@gmail.com')->first();$user5->assignRole('Alumno');

        $perfil = Role::where('name', 'Admin')->first();
        $user = Role::where('name', 'Alumno')->first();
        DB::table('profesors')->insert(['grado_academico' => 'Doctor', 'area' => 'Inteligencia Artificial y Aprendizaje Automático', 'user_id' => '3']);
        DB::table('profesors')->insert(['grado_academico' => 'Doctor', 'area' => 'Inteligencia Artificial y Aprendizaje Automático', 'user_id' => '4']);
        DB::table('alumnos')->insert(['cuatrimestre' => '10', 'matricula' => 'RCMO20032', 'user_id' => '2']);
        DB::table('alumnos')->insert(['cuatrimestre' => '11', 'matricula' => 'HGJO200332', 'user_id' => '5']);

        

        // Cobertura de visibilidad completa
        
        $user->givePermissionTo(Permission::where('name','academico.index')->get());
        $user->givePermissionTo(Permission::where('name','academico.store')->get());
        $user->givePermissionTo(Permission::where('name','academico.update')->get());
        $user->givePermissionTo(Permission::where('name','academico.delete')->get());

        $perfil->givePermissionTo(Permission::where('module_key', 'modulo')->get());
        
        $user->givePermissionTo(Permission::where('name','academico.update')->get());
        $perfil->givePermissionTo(Permission::where('module_key', 'cat')->get());

    }
}
