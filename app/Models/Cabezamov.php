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
        'documento',
        'prefijo',
        'tm',
        'codcp',
        'codsuc',
        'fecha',
        'fechent',
        'comen',
        'valortotal',
        'vriva',
        'descuento',
        'estado',
        'usuario',
        'fechacrea',
        'horacrea'
    ];

    protected $casts = [
        'fecha' => 'date',
        'fechent' => 'date',
        'fechacrea' => 'date',
        'valortotal' => 'decimal:2',
        'vriva' => 'decimal:2',
        'descuento' => 'decimal:2'
    ];
    public function getCodcpAttribute($value)
    {
        return trim($value);
    }
    public function getCodsucAttribute($value)
    {
        return trim($value);
    }
    public function getDocumentoAttribute($value)
    {
        return trim($value);
    }
    public function getTmAttribute($value)
    {
        return trim($value);
    }
    public function getPrefijoAttribute($value)
    {
        return trim($value);
    }
    public function getCodcliAttribute($value)
    {
        return trim($value);
    }

    public function detalles()      //
    {
        // return $this->hasMany(Cuerpomov::class, ['tm', 'documento', 'prefijo'], ['tm', 'documento', 'prefijo']);


        return $this->hasMany(Cuerpomov::class, 'documento', 'documento')
            ->where('tm', trim($this->tm))
            ->where('prefijo', trim($this->prefijo));
    }


    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Gecliente::class, 'codcp', 'codcli');
    }

    /**
     * Obtener la sucursal asociada a la orden.
     */

    // Relación con sucursal 
    public function sucursal()
    {
        // cabezamov.codcp + cabezamov.codsuc → geclientesaux.codcli + geclientesaux.codsuc 
        return $this->belongsTo(Geclientesaux::class, 'codsuc', 'codsuc')
            ->where('codcli', trim($this->codcp));
    }

    public function sucursalxx()
    {
        // Si el código de sucursal está vacío, devuelve null
        if (empty($this->codsuc)) {
            return null;
        }

        // Si hay código de sucursal, busca la sucursal correspondiente
        // return $this->belongsTo(Geclientesaux::class, ['codcp', 'codsuc'], ['codcli', 'codsuc']);

        // Si hay código de sucursal, busca la sucursal correspondiente
        return Geclientesaux::where('codcli', $this->codcp)
            ->where('codsuc', $this->codsuc)
            ->first();
    }
    /**
     * Scope para obtener las órdenes de pedido.
     */
    public function scopeOrdenesPedido($query)
    {
        return $query->where('tm', 'OP');
    }
    /**
     * Scope para obtener las órdenes de un cliente específico.
     */
    public function deCliente($codcli)
    {
        return $this->where('codcp', $codcli);
    }

    /**
     * Scope para obtener las órdenes con un estado específico.
     */
    public function deEstado($estado)
    {
        return $this->where('estado', $estado);
    }

    /**
     * Scope para obtener las órdenes en un rango de fechas.
     */
    public function rangoFechas($fechaInicio, $fechaFin)
    {
        return $this->whereBetween('fecha', $fechaInicio, $fechaFin);
    }
}
