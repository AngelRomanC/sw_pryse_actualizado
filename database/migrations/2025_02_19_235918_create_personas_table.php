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
        Schema::create('personas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 50);
            $table->string('apellido_paterno', 50);
            $table->string('apellido_materno', 100);
            $table->string('sexo', 10);
            $table->date('fecha_nacimiento');
            $table->integer('edad');
            $table->string('entidad_nacimiento', 50);
            $table->string('rfc', 50);
            $table->string('cp', 10);
            $table->string('nss', 50);
            $table->string('cuip', 50);
            $table->string('curp', 50);

            // Clave foránea para registrar el usuario que crea la persona
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personas');
    }
};
