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
        Schema::create('recursamientos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('materia_id')->constrained();
            $table->foreignId("periodo_id")->constrained();
            $table->foreignId("profesor_id")->constrained();
            $table->String("horarios");
            $table->integer("cupo");
            $table->integer("estatus");
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
        Schema::dropIfExists('recursamientos');
    }
};
