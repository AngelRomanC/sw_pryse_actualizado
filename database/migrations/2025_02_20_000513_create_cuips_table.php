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
        Schema::create('cuips', function (Blueprint $table) {
            $table->id();
            $table->foreignId('persona_id')->constrained('personas')->onDelete('cascade'); 
            $table->string('folio_cuip', 50)->nullable();
            $table->date('fecha_expedicion')->nullable();
            $table->string('estatus_rfc', 50)->nullable();
            $table->string('vigencia_ine', 50)->nullable();
            $table->string('estado_ine', 50)->nullable();
            $table->string('valida_ine', 50)->nullable();
            $table->timestamps();  
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cuips');
    }
};
