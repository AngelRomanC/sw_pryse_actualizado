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
        Schema::create('inteligencias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained(); 
            $table->string('matricula');
            $table->integer('formato');
            $table->integer('version');
            $table->integer('estatus');
            $table->foreignId('grupo_id')->constrained(); 
            $table->foreignId('profesor_id')->constrained();
            $table->foreignId('periodo_id')->constrained();
            
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
        Schema::dropIfExists('inteligencias');
    }
};
