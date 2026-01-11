<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FichaTecnicaFoto extends Model
{
    use HasFactory;

    protected $table = 'ficha_tecnica_fotos';

    protected $fillable = [
        'id_ficha_tecnica',
        'ruta_imagen',
    ];

    /**
     * Obtiene la ficha técnica a la que pertenece esta foto.
     */
    public function fichaTecnica()
    {
        return $this->belongsTo(FichaTecnica::class, 'id_ficha_tecnica');
    }
}