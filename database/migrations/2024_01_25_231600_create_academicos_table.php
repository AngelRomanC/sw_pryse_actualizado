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
        Schema::create('academicos', function (Blueprint $table) {
            $table->id();
            $table->string('matricula');
            $table->string('materia_recursar');
            $table->integer('estatus');
            $table->integer('version');
            $table->integer('formato');
            $table->foreignId('grupo_id')->constrained(); 
            $table->foreignId('user_id')->constrained(); 
            $table->foreignId('periodo_id')->constrained();
            $table->foreignId('profesor_id')->constrained();
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
        Schema::dropIfExists('academicos');
    }
};
