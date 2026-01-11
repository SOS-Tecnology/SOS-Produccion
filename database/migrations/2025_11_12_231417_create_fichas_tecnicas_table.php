<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration

{
    public function up(): void
    {
        Schema::create('fichas_tecnicas', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('id_producto_base'); // Relación con inrefinv.codr
            $table->unsignedInteger('id_cliente');       // Relación con geclientes.codcli
            $table->string('nombre_ficha');
            $table->text('adicionales')->nullable();
            $table->decimal('tiempo_corte', 5, 2)->nullable();
            $table->decimal('tiempo_confeccion', 5, 2)->nullable();
            $table->decimal('tiempo_alistamiento', 5, 2)->nullable();
            $table->decimal('tiempo_remate', 5, 2)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fichas_tecnicas');
    }
};