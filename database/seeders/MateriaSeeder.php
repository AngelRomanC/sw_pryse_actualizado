<?php

namespace Database\Seeders;
use App\Models\Materia;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MateriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //cuatrimestre 1
        Materia::create(['nombre'=>'Inglés I','clave'=>'0000','cuatrimestre'=>'1','tipo'=>'Teorico','No_horas_presenciales'=>'6','No_horas_no_presenciales'=>'3','periodo'=>'Sep-Dic','nivel'=>'facil','status'=>'1']);
        Materia::create(['nombre'=>'Química Básica','clave'=>'0000','cuatrimestre'=>'1','tipo'=>'Teorico','No_horas_presenciales'=>'6','No_horas_no_presenciales'=>'3','periodo'=>'Sep-Dic','nivel'=>'facil','status'=>'1']);
        Materia::create(['nombre'=>'Álgebra Lineal','clave'=>'0000','cuatrimestre'=>'1','tipo'=>'Teorico','No_horas_presenciales'=>'6','No_horas_no_presenciales'=>'3','periodo'=>'Sep-Dic','nivel'=>'facil','status'=>'1']);
        Materia::create(['nombre'=>'Introducción a la Programación','clave'=>'0000','cuatrimestre'=>'1','tipo'=>'Teorico','No_horas_presenciales'=>'6','No_horas_no_presenciales'=>'3','periodo'=>'Sep-Dic','nivel'=>'facil','status'=>'1']);
        Materia::create(['nombre'=>'Introducción a las Tecnologías de la Información','clave'=>'0000','cuatrimestre'=>'1','tipo'=>'Teorico','No_horas_presenciales'=>'6','No_horas_no_presenciales'=>'3','periodo'=>'Sep-Dic','nivel'=>'facil','status'=>'1']);
        Materia::create(['nombre'=>'Herramientas Ofimáticas','clave'=>'0000','cuatrimestre'=>'1','tipo'=>'Teorico','No_horas_presenciales'=>'6','No_horas_no_presenciales'=>'3','periodo'=>'Sep-Dic','nivel'=>'facil','status'=>'1']);
        Materia::create(['nombre'=>'Expresión Oral y Escrita','clave'=>'0000','cuatrimestre'=>'1','tipo'=>'Teorico','No_horas_presenciales'=>'6','No_horas_no_presenciales'=>'3','periodo'=>'Sep-Dic','nivel'=>'facil','status'=>'1']);

        //cuatrimestre 2
        Materia::create(['nombre'=>'Inglés II','clave'=>'0000','cuatrimestre'=>'2','tipo'=>'Teorico','No_horas_presenciales'=>'6','No_horas_no_presenciales'=>'3','periodo'=>'Ene-Abr','nivel'=>'facil','status'=>'1']);
        Materia::create(['nombre'=>'Desarrollo Humano y Valores','clave'=>'0000','cuatrimestre'=>'2','tipo'=>'Teorico','No_horas_presenciales'=>'6','No_horas_no_presenciales'=>'3','periodo'=>'Ene-Abr','nivel'=>'facil','status'=>'1']);
        Materia::create(['nombre'=>'Funciones Matemáticas','clave'=>'0000','cuatrimestre'=>'2','tipo'=>'Teorico','No_horas_presenciales'=>'6','No_horas_no_presenciales'=>'3','periodo'=>'Ene-Abr','nivel'=>'facil','status'=>'1']);
        Materia::create(['nombre'=>'Física','clave'=>'0000','cuatrimestre'=>'2','tipo'=>'Teorico','No_horas_presenciales'=>'6','No_horas_no_presenciales'=>'3','periodo'=>'Ene-Abr','nivel'=>'facil','status'=>'1']);
        Materia::create(['nombre'=>'Electricidad y Magnetismo','clave'=>'0000','cuatrimestre'=>'2','tipo'=>'Teorico','No_horas_presenciales'=>'6','No_horas_no_presenciales'=>'3','periodo'=>'Ene-Abr','nivel'=>'facil','status'=>'1']);
        Materia::create(['nombre'=>'Matemáticas Básicas para Computación','clave'=>'0000','cuatrimestre'=>'2','tipo'=>'Teorico','No_horas_presenciales'=>'6','No_horas_no_presenciales'=>'3','periodo'=>'Ene-Abr','nivel'=>'facil','status'=>'1']);
        Materia::create(['nombre'=>'Arquitectura de Computadoras','clave'=>'0000','cuatrimestre'=>'2','tipo'=>'Teorico','No_horas_presenciales'=>'6','No_horas_no_presenciales'=>'3','periodo'=>'Ene-Abr','nivel'=>'facil','status'=>'1']);

        //cuatrimestre 3
        Materia::create(['nombre'=>'Inglés III','clave'=>'0000','cuatrimestre'=>'3','tipo'=>'Teorico','No_horas_presenciales'=>'6','No_horas_no_presenciales'=>'3','periodo'=>'May-Ago','nivel'=>'facil','status'=>'1']);
        Materia::create(['nombre'=>'Inteligencia Emocional y Manejo de Conflictos','clave'=>'0000','cuatrimestre'=>'3','tipo'=>'Teorico','No_horas_presenciales'=>'6','No_horas_no_presenciales'=>'3','periodo'=>'May-Ago','nivel'=>'facil','status'=>'1']);
        Materia::create(['nombre'=>'Cálculo Diferencial','clave'=>'0000','cuatrimestre'=>'3','tipo'=>'Teorico','No_horas_presenciales'=>'6','No_horas_no_presenciales'=>'3','periodo'=>'May-Ago','nivel'=>'facil','status'=>'1']);
        Materia::create(['nombre'=>'Probabilidad y Estadística','clave'=>'0000','cuatrimestre'=>'3','tipo'=>'Teorico','No_horas_presenciales'=>'6','No_horas_no_presenciales'=>'3','periodo'=>'May-Ago','nivel'=>'facil','status'=>'1']);
        Materia::create(['nombre'=>'Programación','clave'=>'0000','cuatrimestre'=>'3','tipo'=>'Teorico','No_horas_presenciales'=>'6','No_horas_no_presenciales'=>'3','periodo'=>'May-Ago','nivel'=>'facil','status'=>'1']);
        Materia::create(['nombre'=>'Introducción a Redes','clave'=>'0000','cuatrimestre'=>'3','tipo'=>'Teorico','No_horas_presenciales'=>'6','No_horas_no_presenciales'=>'3','periodo'=>'May-Ago','nivel'=>'facil','status'=>'1']);
        Materia::create(['nombre'=>'Mantenimiento a Equipo de Cómputo','clave'=>'0000','cuatrimestre'=>'3','tipo'=>'Teorico','No_horas_presenciales'=>'6','No_horas_no_presenciales'=>'3','periodo'=>'May-Ago','nivel'=>'facil','status'=>'1']);

        //cuatrimestre 4
        Materia::create(['nombre'=>'Inglés IV','clave'=>'0000','cuatrimestre'=>'4','tipo'=>'Teorico','No_horas_presenciales'=>'6','No_horas_no_presenciales'=>'3','periodo'=>'Sep-Dic','nivel'=>'facil','status'=>'1']);
        Materia::create(['nombre'=>'Habilidades Cognitivas y Creatividad','clave'=>'0000','cuatrimestre'=>'4','tipo'=>'Teorico','No_horas_presenciales'=>'6','No_horas_no_presenciales'=>'3','periodo'=>'Sep-Dic','nivel'=>'facil','status'=>'1']);
        Materia::create(['nombre'=>'Cálculo Integral','clave'=>'0000','cuatrimestre'=>'4','tipo'=>'Teorico','No_horas_presenciales'=>'6','No_horas_no_presenciales'=>'3','periodo'=>'Sep-Dic','nivel'=>'facil','status'=>'1']);
        Materia::create(['nombre'=>'Ingeniería de Software','clave'=>'0000','cuatrimestre'=>'4','tipo'=>'Teorico','No_horas_presenciales'=>'6','No_horas_no_presenciales'=>'3','periodo'=>'Sep-Dic','nivel'=>'facil','status'=>'1']);
        Materia::create(['nombre'=>'Estructura de Datos','clave'=>'0000','cuatrimestre'=>'4','tipo'=>'Teorico','No_horas_presenciales'=>'6','No_horas_no_presenciales'=>'3','periodo'=>'Sep-Dic','nivel'=>'facil','status'=>'1']);
        Materia::create(['nombre'=>'Ruteo y Conmutación','clave'=>'0000','cuatrimestre'=>'4','tipo'=>'Teorico','No_horas_presenciales'=>'6','No_horas_no_presenciales'=>'3','periodo'=>'Sep-Dic','nivel'=>'facil','status'=>'1']);
        Materia::create(['nombre'=>'Estancia I','clave'=>'0000','cuatrimestre'=>'4','tipo'=>'Teorico','No_horas_presenciales'=>'6','No_horas_no_presenciales'=>'3','periodo'=>'Sep-Dic','nivel'=>'facil','status'=>'1']);

        //cuatrimestre 5
        Materia::create(['nombre'=>'Inglés V','clave'=>'0000','cuatrimestre'=>'5','tipo'=>'Teorico','No_horas_presenciales'=>'6','No_horas_no_presenciales'=>'3','periodo'=>'Ene-Abr','nivel'=>'facil','status'=>'1']);
        Materia::create(['nombre'=>'Ética Profesional','clave'=>'0000','cuatrimestre'=>'5','tipo'=>'Teorico','No_horas_presenciales'=>'6','No_horas_no_presenciales'=>'3','periodo'=>'Ene-Abr','nivel'=>'facil','status'=>'1']);
        Materia::create(['nombre'=>'Matemáticas para Ingeniería I','clave'=>'0000','cuatrimestre'=>'5','tipo'=>'Teorico','No_horas_presenciales'=>'6','No_horas_no_presenciales'=>'3','periodo'=>'Ene-Abr','nivel'=>'facil','status'=>'1']);
        Materia::create(['nombre'=>'Física para Ingeniería','clave'=>'0000','cuatrimestre'=>'5','tipo'=>'Teorico','No_horas_presenciales'=>'6','No_horas_no_presenciales'=>'3','periodo'=>'Ene-Abr','nivel'=>'facil','status'=>'1']);
        Materia::create(['nombre'=>'Fundamentos de Programación Orientada a Objetos','clave'=>'0000','cuatrimestre'=>'5','tipo'=>'Teorico','No_horas_presenciales'=>'6','No_horas_no_presenciales'=>'3','periodo'=>'Ene-Abr','nivel'=>'facil','status'=>'1']);
        Materia::create(['nombre'=>'Escalamiento de Redes','clave'=>'0000','cuatrimestre'=>'5','tipo'=>'Teorico','No_horas_presenciales'=>'6','No_horas_no_presenciales'=>'3','periodo'=>'Ene-Abr','nivel'=>'facil','status'=>'1']);
        Materia::create(['nombre'=>'Base de Datos','clave'=>'0000','cuatrimestre'=>'5','tipo'=>'Teorico','No_horas_presenciales'=>'6','No_horas_no_presenciales'=>'3','periodo'=>'Ene-Abr','nivel'=>'facil','status'=>'1']);

        //cuatrimestre 6
        Materia::create(['nombre'=>'Inglés VI','clave'=>'0000','cuatrimestre'=>'6','tipo'=>'Teorico','No_horas_presenciales'=>'6','No_horas_no_presenciales'=>'3','periodo'=>'May-Ago','nivel'=>'facil','status'=>'1']);
        Materia::create(['nombre'=>'Habilidades Gerenciales','clave'=>'0000','cuatrimestre'=>'6','tipo'=>'Teorico','No_horas_presenciales'=>'6','No_horas_no_presenciales'=>'3','periodo'=>'May-Ago','nivel'=>'facil','status'=>'1']);
        Materia::create(['nombre'=>'Matemáticas para Ingeniería II','clave'=>'0000','cuatrimestre'=>'6','tipo'=>'Teorico','No_horas_presenciales'=>'6','No_horas_no_presenciales'=>'3','periodo'=>'May-Ago','nivel'=>'facil','status'=>'1']);
        Materia::create(['nombre'=>'Sistemas Operativos','clave'=>'0000','cuatrimestre'=>'6','tipo'=>'Teorico','No_horas_presenciales'=>'6','No_horas_no_presenciales'=>'3','periodo'=>'May-Ago','nivel'=>'facil','status'=>'1']);
        Materia::create(['nombre'=>'Programación Orientada a Objetos','clave'=>'0000','cuatrimestre'=>'6','tipo'=>'Teorico','No_horas_presenciales'=>'6','No_horas_no_presenciales'=>'3','periodo'=>'May-Ago','nivel'=>'facil','status'=>'1']);
        Materia::create(['nombre'=>'Interconexión de Redes','clave'=>'0000','cuatrimestre'=>'6','tipo'=>'Teorico','No_horas_presenciales'=>'6','No_horas_no_presenciales'=>'3','periodo'=>'May-Ago','nivel'=>'facil','status'=>'1']);
        Materia::create(['nombre'=>'Administración de Base de Datos','clave'=>'0000','cuatrimestre'=>'6','tipo'=>'Teorico','No_horas_presenciales'=>'6','No_horas_no_presenciales'=>'3','periodo'=>'May-Ago','nivel'=>'facil','status'=>'1']);

        //cuatrimestre 7
        Materia::create(['nombre'=>'Inglés VII','clave'=>'0000','cuatrimestre'=>'7','tipo'=>'Teorico','No_horas_presenciales'=>'6','No_horas_no_presenciales'=>'3','periodo'=>'Sep-Dic','nivel'=>'facil','status'=>'1']);
        Materia::create(['nombre'=>'Liderazgo de Equipos de Alto Desempeño','clave'=>'0000','cuatrimestre'=>'7','tipo'=>'Teorico','No_horas_presenciales'=>'6','No_horas_no_presenciales'=>'3','periodo'=>'Sep-Dic','nivel'=>'facil','status'=>'1']);
        Materia::create(['nombre'=>'Formulación de Proyectos de Tecnologías de Información','clave'=>'0000','cuatrimestre'=>'7','tipo'=>'Teorico','No_horas_presenciales'=>'6','No_horas_no_presenciales'=>'3','periodo'=>'Sep-Dic','nivel'=>'facil','status'=>'1']);
        Materia::create(['nombre'=>'Lenguajes y Autómatas','clave'=>'0000','cuatrimestre'=>'7','tipo'=>'Teorico','No_horas_presenciales'=>'6','No_horas_no_presenciales'=>'3','periodo'=>'Sep-Dic','nivel'=>'facil','status'=>'1']);
        Materia::create(['nombre'=>'Ingeniería de Requisitos','clave'=>'0000','cuatrimestre'=>'7','tipo'=>'Teorico','No_horas_presenciales'=>'6','No_horas_no_presenciales'=>'3','periodo'=>'Sep-Dic','nivel'=>'facil','status'=>'1']);
        Materia::create(['nombre'=>'Programación Web','clave'=>'0000','cuatrimestre'=>'7','tipo'=>'Teorico','No_horas_presenciales'=>'6','No_horas_no_presenciales'=>'3','periodo'=>'Sep-Dic','nivel'=>'facil','status'=>'1']);
        Materia::create(['nombre'=>'Estancia II','clave'=>'0000','cuatrimestre'=>'7','tipo'=>'Teorico','No_horas_presenciales'=>'6','No_horas_no_presenciales'=>'3','periodo'=>'Sep-Dic','nivel'=>'facil','status'=>'1']);

        //cuatrimestre 8
        Materia::create(['nombre'=>'Inglés VIII','clave'=>'0000','cuatrimestre'=>'8','tipo'=>'Teorico','No_horas_presenciales'=>'6','No_horas_no_presenciales'=>'3','periodo'=>'Ene-Abr','nivel'=>'facil','status'=>'1']);
        Materia::create(['nombre'=>'Tecnologías de Virtualización','clave'=>'0000','cuatrimestre'=>'8','tipo'=>'Teorico','No_horas_presenciales'=>'6','No_horas_no_presenciales'=>'3','periodo'=>'Ene-Abr','nivel'=>'facil','status'=>'1']);
        Materia::create(['nombre'=>'Administración de Proyectos de Tecnologías de la Información','clave'=>'0000','cuatrimestre'=>'8','tipo'=>'Teorico','No_horas_presenciales'=>'6','No_horas_no_presenciales'=>'3','periodo'=>'Ene-Abr','nivel'=>'facil','status'=>'1']);
        Materia::create(['nombre'=>'Tecnologías y Aplicaciones en Internet','clave'=>'0000','cuatrimestre'=>'8','tipo'=>'Teorico','No_horas_presenciales'=>'6','No_horas_no_presenciales'=>'3','periodo'=>'Ene-Abr','nivel'=>'facil','status'=>'1']);
        Materia::create(['nombre'=>'Diseño de Interfaces','clave'=>'0000','cuatrimestre'=>'8','tipo'=>'Teorico','No_horas_presenciales'=>'6','No_horas_no_presenciales'=>'3','periodo'=>'Ene-Abr','nivel'=>'facil','status'=>'1']);
        Materia::create(['nombre'=>'Sistemas Inteligentes','clave'=>'0000','cuatrimestre'=>'8','tipo'=>'Teorico','No_horas_presenciales'=>'6','No_horas_no_presenciales'=>'3','periodo'=>'Ene-Abr','nivel'=>'facil','status'=>'1']);
        Materia::create(['nombre'=>'Gestión de Desarrollo de Software','clave'=>'0000','cuatrimestre'=>'8','tipo'=>'Teorico','No_horas_presenciales'=>'6','No_horas_no_presenciales'=>'3','periodo'=>'Ene-Abr','nivel'=>'facil','status'=>'1']);

        //cuatrimestre 9
        Materia::create(['nombre'=>'Inglés IX','clave'=>'0000','cuatrimestre'=>'9','tipo'=>'Teorico','No_horas_presenciales'=>'6','No_horas_no_presenciales'=>'3','periodo'=>'May-Ago','nivel'=>'facil','status'=>'1']);
        Materia::create(['nombre'=>'Inteligencia de Negocios','clave'=>'0000','cuatrimestre'=>'9','tipo'=>'Teorico','No_horas_presenciales'=>'6','No_horas_no_presenciales'=>'3','periodo'=>'May-Ago','nivel'=>'facil','status'=>'1']);
        Materia::create(['nombre'=>'Desarrollo de Negocios para Tecnologías de la Información','clave'=>'0000','cuatrimestre'=>'9','tipo'=>'Teorico','No_horas_presenciales'=>'6','No_horas_no_presenciales'=>'3','periodo'=>'May-Ago','nivel'=>'facil','status'=>'1']);
        Materia::create(['nombre'=>'Sistemas embébidos','clave'=>'0000','cuatrimestre'=>'9','tipo'=>'Teorico','No_horas_presenciales'=>'6','No_horas_no_presenciales'=>'3','periodo'=>'May-Ago','nivel'=>'facil','status'=>'1']);
        Materia::create(['nombre'=>'Programación Móvil','clave'=>'0000','cuatrimestre'=>'9','tipo'=>'Teorico','No_horas_presenciales'=>'6','No_horas_no_presenciales'=>'3','periodo'=>'May-Ago','nivel'=>'facil','status'=>'1']);
        Materia::create(['nombre'=>'Seguridad Informática','clave'=>'0000','cuatrimestre'=>'9','tipo'=>'Teorico','No_horas_presenciales'=>'6','No_horas_no_presenciales'=>'3','periodo'=>'May-Ago','nivel'=>'facil','status'=>'1']);
        Materia::create(['nombre'=>'Expresión Oral y Escrita II','clave'=>'0000','cuatrimestre'=>'9','tipo'=>'Teorico','No_horas_presenciales'=>'6','No_horas_no_presenciales'=>'3','periodo'=>'May-Ago','nivel'=>'facil','status'=>'1']);

    }
}
