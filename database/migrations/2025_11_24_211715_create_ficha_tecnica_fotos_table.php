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
        Schema::create('ficha_tecnica_fotos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_ficha_tecnica');
            $table->string('ruta_imagen');
            $table->timestamps();

            // Definimos la clave foránea que apunta a la tabla 'fichas_tecnicas'
            $table->foreign('id_ficha_tecnica')
                  ->references('id')
                  ->on('fichas_tecnicas')
                  ->onDelete('cascade'); // Si se borra la ficha, se borran sus fotos
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ficha_tecnica_fotos');
    }
};
