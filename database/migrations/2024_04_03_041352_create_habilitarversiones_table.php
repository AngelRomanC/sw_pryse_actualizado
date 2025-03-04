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
        Schema::create('habilitarversiones', function (Blueprint $table) {
            $table->id();
            $table->integer('estatus');
            $table->integer('version');
            $table->integer('formato');
            $table->foreignId('grupo_alumno')->constrained('grupo_alumnos');
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
        Schema::dropIfExists('habilitarversiones');
    }
};
