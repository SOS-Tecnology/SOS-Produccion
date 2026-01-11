<?php

// database/migrations/xxxx_xx_xx_xxxxxx_create_satelites_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('satelites', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('id_proveedor'); // Relación con provee.codp
            $table->enum('tipo', ['Corte', 'Confeccion']);
            $table->string('especialidad')->nullable();
            $table->unsignedInteger('capacidad_produccion')->nullable();
            $table->decimal('calificacion', 2, 1)->nullable();
            $table->text('comentarios')->nullable();
            $table->enum('estado', ['Activo', 'Bloqueado'])->default('Activo');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('satelites');
    }
};
