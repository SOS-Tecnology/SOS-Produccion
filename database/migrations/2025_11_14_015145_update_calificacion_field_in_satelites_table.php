<?php
// database/migrations/xxxx_xx_xx_xxxxxx_update_calificacion_field_in_satelites_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('satelites', function (Blueprint $table) {
            // Cambiamos DECIMAL(2,1) a DECIMAL(3,1) para permitir valores de 0.0 a 9.9
            $table->decimal('calificacion', 3, 1)->change();
        });
    }

    public function down(): void
    {
        Schema::table('satelites', function (Blueprint $table) {
            $table->decimal('calificacion', 2, 1)->change();
        });
    }
};