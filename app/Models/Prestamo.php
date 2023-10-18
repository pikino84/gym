<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prestamo extends Model
{
    use HasFactory;
    protected $table = 'prestamos';
    protected $fillable = [
        'cididdocumento',
        'user_id',
        'fecha',
        'folio',
        'serie',
        'total',
        'naturaleza',
    ];
}
