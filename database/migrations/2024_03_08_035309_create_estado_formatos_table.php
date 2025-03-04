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
        Schema::create('estado_formatos', function (Blueprint $table) {
            $table->id();
            $table->string('version_id');
            $table->integer('formato');
            $table->boolean('estado')->default(1); 
            $table->timestamps();
            
        });
    }


    public function down()
    {
        Schema::dropIfExists('estado_formatos');
    }
};
