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
        Schema::create('documentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('persona_id')->constrained('personas')->onDelete('cascade'); 
            $table->string('doc_curp', 255)->nullable();
            $table->string('doc_rfc', 255)->nullable();
            $table->string('acta_nacimiento', 255)->nullable();
            $table->string('doc_cuip', 255)->nullable();
            $table->string('ine', 255)->nullable();
            $table->string('cartilla_militar', 255)->nullable();
            $table->string('comprobante_domicilio', 255)->nullable();
            $table->string('doc_nss', 255)->nullable();
            $table->string('firma_digital', 255)->nullable();
            $table->string('estatus')->default('incompleto'); // Nuevo campo

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documentos');
    }
};
