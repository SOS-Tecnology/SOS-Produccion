<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inrefinv extends Model
{
    use HasFactory;

    // --- ESTA ES LA LÍNEA CLAVE ---
    protected $table = 'inrefinv';

    protected $primaryKey = 'codr';
    public $timestamps = false;
    public $incrementing = false; // si codr no es autoincremental

    protected $fillable = [
        'descr',
        'unid',
    ];
    
    public function detalles()
    {
        return $this->hasMany(Cuerpomov::class, 'codr', 'codr');
    }
}
