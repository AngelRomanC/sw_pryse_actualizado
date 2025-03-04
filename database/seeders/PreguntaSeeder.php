<?php

namespace Database\Seeders;
use App\Models\Pregunta;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PreguntaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Formato de analisis academico    
           Pregunta::create(['pregunta'=>'No. de materias reprobadas acumuladas','formato'=>'1','version'=>'1','estatus'=>'1']);
           Pregunta::create(['pregunta'=>'Nombre de las materias reprobadas a cumuladas','formato'=>'1','version'=>'1','estatus'=>'1']);
           Pregunta::create(['pregunta'=>'No. de materias en recursamiento (actual)','formato'=>'1','version'=>'1','estatus'=>'1']);
           Pregunta::create(['pregunta'=>'Nombre de las materias en recursamiento (actual)','formato'=>'1','version'=>'1','estatus'=>'1']);
           Pregunta::create(['pregunta'=>'No. de materias ya recursadas y acreditadas','formato'=>'1','version'=>'1','estatus'=>'1']);    
           Pregunta::create(['pregunta'=>'Nombre de las materias ya recursadas y acreditadas','formato'=>'1','version'=>'1','estatus'=>'1']);
           Pregunta::create(['pregunta'=>'No. de materias en recursamiento (pendientes)','formato'=>'1','version'=>'1','estatus'=>'1']);
           Pregunta::create(['pregunta'=>'Nombre de las materias en recursamiento (pendientes)','formato'=>'1','version'=>'1','estatus'=>'1']);
           Pregunta::create(['pregunta'=>'No. de niveles de inglés no acreditados','formato'=>'1','version'=>'1','estatus'=>'1']);
           Pregunta::create(['pregunta'=>'No. de materias en segundo recursamiento ','formato'=>'1','version'=>'1','estatus'=>'1']);  
           Pregunta::create(['pregunta'=>'Promedio de carrera ','formato'=>'1','version'=>'1','estatus'=>'1']);     
        //Formatos de habitos de estudio
        Pregunta::create(['pregunta'=>'No. de horas que estudias al dia','formato'=>'2','version'=>'1','estatus'=>'1']);
        Pregunta::create(['pregunta'=>'En que horarios estudias','formato'=>'2','version'=>'1','estatus'=>'1']);
        Pregunta::create(['pregunta'=>'Cual es tui entorno de estudio','formato'=>'2','version'=>'1','estatus'=>'1']);
        Pregunta::create(['pregunta'=>'Tecnologías utilizadas en el estudio','formato'=>'2','version'=>'1','estatus'=>'1']);
        Pregunta::create(['pregunta'=>'Registro de recursos','formato'=>'2','version'=>'1','estatus'=>'1']);    
        Pregunta::create(['pregunta'=>'Estado Fisiológico','formato'=>'2','version'=>'1','estatus'=>'1']);
        
        //Formatos de habitos de estudio
        Pregunta::create(['pregunta'=>'Prefiero hacer un mapa que explicarle a alguien como tiene que llegar.','formato'=>'3','version'=>'1','estatus'=>'1']);
        Pregunta::create(['pregunta'=>' Si estoy enojado(a) o contento (a) generalmente sé exactamente por qué','formato'=>'3','version'=>'1','estatus'=>'1']);
        Pregunta::create(['pregunta'=>'Sé tocar (o antes sabía tocar) un instrumento musical','formato'=>'3','version'=>'1','estatus'=>'1']);
        Pregunta::create(['pregunta'=>'Asocio la música con mis estados de ánimo','formato'=>'3','version'=>'1','estatus'=>'1']);
        Pregunta::create(['pregunta'=>'Registro de recursos','formato'=>'3','version'=>'1','estatus'=>'1']);
        Pregunta::create(['pregunta'=>'Estado Fisiológico','formato'=>'3','version'=>'1','estatus'=>'1']);


           
    }
}
