<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstadosDeCuenta extends Model
{
    use HasFactory;

    protected $fillable = ['id_fac_compac', 'nombre', 'descripcion', 'monto', 'status', 'pdf', 'xml'];

    public function validar()
    {
        return [
            'id_fac_compac' => 'required|unique:proveedores',
            'nombre' => 'required',
            'descripcion' => 'required',
            'monto' => 'required|numeric',
            'status' => 'integer',
            'pdf' => 'nullable|mimes:pdf',
            'xml' => 'nullable|mimes:xml',
        ];
    }
}