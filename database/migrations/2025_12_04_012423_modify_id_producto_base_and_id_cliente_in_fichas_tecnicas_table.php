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
        Schema::table('fichas_tecnicas', function (Blueprint $table) {
            // Cambiamos la columna id_producto_base de integer a string
            $table->string('id_producto_base', 255)->change();
            
            // Cambiamos la columna id_cliente de integer a string
            $table->string('id_cliente', 255)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fichas_tecnicas', function (Blueprint $table) {
            // Revertimos los cambios: volvemos a ponerlas como integer
            $table->integer('id_producto_base')->change();
            $table->integer('id_cliente')->change();
        });
    }
};
