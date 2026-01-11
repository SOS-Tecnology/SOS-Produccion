<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Geclientesaux extends Model
{
    protected $table = 'geclientesaux';
    
    protected $primaryKey = ['codcli', 'codsuc'];
    public $incrementing = false;
    
    protected $fillable = [
        'codcli', 'codsuc', 'nombresuc', 'direccionpago', 'contacto1', 
        'cargo1', 'celular1', 'email1', 'telefonosuc'
    ];
    
    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Gecliente::class, 'codcli', 'codcli');
    }
}