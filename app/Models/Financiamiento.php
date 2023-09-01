<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Financiamiento extends Model
{
    use HasFactory;
    protected $fillable = [
        'cididdocumento',
        'fecha',
        'serie',
        'folio',
        'prestamos',
        'descuentos',
        'deuda_total',
    ];

    public function validar(){
        return [
            'cididdocumento' => 'required',
            'fecha' => 'required',
            'serie' => 'required',
            'folio' => 'required',
            'prestamos' => 'required',
            'descuentos' => 'required',
            'deuda_total' => 'required',
        ];
    }
}
