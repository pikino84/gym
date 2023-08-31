<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fruta extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'cididdocumento', 'fecha', 'serie', 'folio', 'semana', 'nombre', 'talla', 'total'];

    public function validar()
    {
        return [
            'id' => 'required',
            'cididdocumento' => 'required',
            'fecha' => 'required',
            'serie' => 'required',
            'folio' => 'required',
            'semana' => 'required',
            'nombre' => 'required',
            'talla' => 'required',
            'total' => 'required'
        ];
    }
}
