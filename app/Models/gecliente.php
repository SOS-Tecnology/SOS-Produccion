<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gecliente extends Model
{
    use HasFactory;

    protected $table = 'geclientes';

    // --- ESTA LÍNEA TAMBIÉN ES MUY IMPORTANTE ---
    protected $primaryKey = 'codcli';

    public $timestamps = false;

    protected $fillable = [
        'nombrecli',
    ];
}