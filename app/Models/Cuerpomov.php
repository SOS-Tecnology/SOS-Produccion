<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cuerpomov extends Model
{
    protected $table = 'cuerpomov';
    
    protected $primaryKey = ['tm', 'documento', 'prefijo', 'codr'];
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
    
    public function producto(): BelongsTo
    {
        return $this->belongsTo(Inrefinv::class, 'codr', 'codr');
    }
    
    public function scopeOrdenesPedido($query)
    {
        return $query->where('tm', 'OP');
    }
}