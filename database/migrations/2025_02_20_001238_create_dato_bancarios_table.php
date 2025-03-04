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
        Schema::create('dato_bancarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId(column: 'persona_id')->constrained('personas')->onDelete('cascade'); 
            $table->string('nombre_titular', 100); // Nombre del titular ejemplooos
            $table->string('nombre_banco', 100); // Nombre del banco
            $table->string('numero_cuenta', 50); // Número de cuenta
            $table->string('numero_clabe', 50); // Número CLABE (si aplica)            $table->timestamps();
            $table->string('tipo_cuenta', 50); // Tipo de cuenta (por ejemplo, Ahorros, Corriente)

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dato_bancarios');
    }
};
