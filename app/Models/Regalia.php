<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Regalia extends Model
{
    use HasFactory;
    protected $fillable = ['cididdocumento', 'user_id', 'fecha', 'semana', 'serie', 'folio', 'concepto', 'importe', 'iva', 'total', 'pendiente'];

    public function validar()
    {
        return [
            'cididdocumento' => 'required',
            'user_id' => 'required',
            'fecha' => 'required',
            'semana' => 'required',
            'serie' => 'required',
            'folio' => 'required',
            'concepto' => 'required',
            'importe' => 'required',
            'iva' => 'required',
            'total' => 'required',
            'pendiente' => 'required'
        ];
    }
}
