<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('canpes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('persona_id')->constrained('personas')->onDelete('cascade'); 
            $table->string('registrado_canpe', 50)->nullable();
            $table->string('estatus_canpe', 50)->nullable();            
            $table->string('correo_canpe', 50)->nullable()->unique();;
            $table->string('password_canpe', 50)->nullable();
            $table->boolean('inaccesible_canpe');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('canpes');
    }
};
