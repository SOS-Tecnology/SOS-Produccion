<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Proveedor extends Model
{
    use HasFactory;

    // 1. Especificar el nombre de la tabla
    protected $table = 'provee';

    // 2. Especificar la clave primaria
    protected $primaryKey = 'codp';

    // 3. Desactivar las marcas de tiempo si tu tabla no las tiene
    public $timestamps = false;
}
