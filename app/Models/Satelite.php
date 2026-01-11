<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Satelite extends Model
{
    use HasFactory;

    // 1. Nombre de la tabla en la BD
    protected $table = 'satelites';

    // 2. Clave primaria de la tabla
    protected $primaryKey = 'id';

    // 3. Campos que se pueden llenar masivamente (seguridad)
    protected $fillable = [
        'id_proveedor',
        'tipo',
        'especialidad',
        'capacidad_produccion',
        'calificacion',
        'comentarios',
        'estado',
    ];

    // 4. Conversión de tipos de datos
    protected $casts = [
        'capacidad_produccion' => 'integer',
        'calificacion' => 'float',
        'estado' => 'string',
    ];

    // 5. Relación con la tabla de Proveedores
    // Un satélite pertenece a un proveedor
    public function proveedor()
    {
        // Asumimos que existe un modelo Proveedor que apunta a la tabla 'provee'
        // y que su clave primaria es 'codp'.
        return $this->belongsTo(Proveedor::class, 'id_proveedor', 'codp');
    }
}