<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('encuestas', function (Blueprint $table) {
            $table->id();
            $table->string('horario');
            $table->string('profesores');
            $table->string('tipo_proyecto');
            $table->string('dificultad');
            $table->string('estudiantes');
            $table->foreignId('materia_id')->constrained('materias');
            $table->foreignId('user_id')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('encuestas');
    }
};
