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

    protected $fillable = [
        'descr',
        'unid',
    ];
}