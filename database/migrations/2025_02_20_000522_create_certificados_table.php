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
        Schema::create('certificados', function (Blueprint $table) {
            $table->id();
            $table->foreignId('persona_id')->constrained('personas')->onDelete('cascade'); 
            $table->string('certificado_primaria', 50);
            $table->string('estatus_primaria', 50);
            $table->string('certificado_secundaria', 50);
            $table->string('estatus_secundaria', 50);           
            $table->string('certificado_preparatoria', 50);
            $table->string('estatus_preparatoria', length: 50);
            $table->string('certificado_universidad', length: 50);
            $table->string('estatus_universidad', 50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificados');
    }
};
