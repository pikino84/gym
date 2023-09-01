<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Regalia extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'fecha', 'semana', 'serie', 'folio', 'concepto', 'importe', 'iva', 'total'];

    public function validar()
    {
        return [
            'id' => 'required',
            'fecha' => 'required',
            'semana' => 'required',
            'serie' => 'required',
            'folio' => 'required',
            'concepto' => 'required',
            'importe' => 'required',
            'iva' => 'required',
            'total' => 'required'
        ];
    }
}
