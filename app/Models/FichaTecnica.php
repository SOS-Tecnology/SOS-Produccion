<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FichaTecnica extends Model
{
    use HasFactory;

    protected $table = 'fichas_tecnicas';

    protected $fillable = [
        'id_producto_base',
        'id_cliente',
        'nombre_ficha',
        'adicionales',
        'tiempo_corte',
        'tiempo_confeccion',
        'tiempo_alistamiento',
        'tiempo_remate',
    ];

    // Relación: Una ficha técnica pertenece a un producto base (inrefinv)
    public function productoBase()
    {
        return $this->belongsTo(Inrefinv::class, 'id_producto_base', 'codr');
    }

    // Relación: Una ficha técnica pertenece a un cliente (geclientes)
    public function cliente()
    {
        return $this->belongsTo(Gecliente::class, 'id_cliente', 'codcli');
    }

    // Relación: Una ficha técnica puede tener muchas fotos
    public function fotos()
    {
        return $this->hasMany(FichaTecnicaFoto::class, 'id_ficha_tecnica');
    }
}