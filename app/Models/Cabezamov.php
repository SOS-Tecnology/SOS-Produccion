<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cabezamov extends Model
{
    // use HasFactory;

    protected $table = 'cabezamov';
    
    protected $primaryKey = ['tm', 'documento', 'prefijo'];
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = [
        'documento', 'prefijo', 'tm', 'codcp', 'codsuc', 'fecha', 
        'fechent', 'comen', 'valortotal', 'vriva', 'descuento', 
        'estado', 'usuario', 'fechacrea', 'horacrea'
    ];
    
    protected $casts = [
        'fecha' => 'date',
        'fechent' => 'date',
        'fechacrea' => 'date',
        'valortotal' => 'decimal:2',
        'vriva' => 'decimal:2',
        'descuento' => 'decimal:2'
    ];
    
    public function detalles(): HasMany
    {
        return $this->hasMany(Cuerpomov::class, ['tm', 'documento', 'prefijo'], ['tm', 'documento', 'prefijo']);
    }
    
    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Gecliente::class, 'codcp', 'codcli');
    }
    
    public function sucursal(): BelongsTo
    {
        return $this->belongsTo(Geclientesaux::class, ['codcp', 'codsuc'], ['codcli', 'codsuc']);
    }
    
    public function scopeOrdenesPedido($query)
    {
        return $query->where('tm', 'OP');
    }
}