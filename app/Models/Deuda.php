<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deuda extends Model
{
    use HasFactory;
    protected $fillable = [
        'cididdocumento',
        'fecha',
        'serie',
        'folio',
        'importe',
        'total_unidades',
        'moneda',
        'descuentos',
        'saldo',
    ];

    public function validar(){
        return [
            'cididdocumento' => 'required',
            'fecha' => 'required',
            'serie' => 'required',
            'folio' => 'required',
            'importe' => 'required',
            'total_unidades' => 'required',
            'moneda' => 'required',
            'descuentos' => 'required',
            'saldo' => 'required',
        ];
    }

}
