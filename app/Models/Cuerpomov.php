<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cuerpomov extends Model
{
    protected $table = 'cuerpomov';
    
    // protected $primaryKey = ['tm', 'documento', 'prefijo', 'codr'];
    // public $incrementing = false;

    
    protected $primaryKey = ['tm', 'documento', 'prefijo'];
    public $incrementing = false;    
    public $timestamps = false;
    protected $fillable = [
        'documento', 'prefijo', 'tm', 'codr', 'descr', 'cantidad', 
        'valor', 'unidad', 'codcolor', 'codtalla'
    ];
    
    protected $casts = [
        'cantidad' => 'decimal:2',
        'valor' => 'decimal:3'
    ];
    
    public function cabezamov(): BelongsTo
    {
        return $this->belongsTo(Cabezamov::class, ['tm', 'documento', 'prefijo'], ['tm', 'documento', 'prefijo']);
    }
    
    public function producto()
    {
                // Siempre devuelve null para evitar el error
        // return null;
        return $this->belongsTo(Inrefinv::class, 'codr', 'codr');
    }

    // Relación inversa con Cabezamov
    public function orden()
    {
        return $this->belongsTo(Cabezamov::class, 'documento', 'documento')
            ->where('tm', $this->tm)
            ->where('prefijo', $this->prefijo);
    }

    public function scopeOrdenesPedido($query)
    {
        return $query->where('tm', 'OP');
    }
        /**
     * Obtener los detalles (cuerpo) del documento.
     */
    public function detalles()
    {
        // La clave foránea está definida como un array
        return $this->hasMany(Cuerpomov::class, ['tm', 'documento', 'prefijo'], ['tm', 'documento', 'prefijo'], ['tm', 'documento', 'prefijo']);

        // La clave foránea está definida como un array.
    }
}