<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    protected $fillable = ['id_invoice', 'id_user', 'description', 'financiamiento', 'regalias', 'plantas', 'materiales', 'monto', 'moneda', 'tipocambio', 'fecha', 'semana', 'razonsocial', 'cancelado', 'id_status', 'pdf', 'xml'];

    public function validar()
    {
        return [
            'idproveedor' => 'required',
            'id_invoice' => 'required|unique:proveedores',
            'description' => 'required',
            'financiamiento' => 'required|numeric',
            'regalias' => 'required|numeric',
            'plantas' => 'required|numeric',
            'materiales' => 'required|numeric',
            'monto' => 'required|numeric',
            'razonsocial' => 'required',
            'status' => 'integer',
            'pdf' => 'nullable|mimes:pdf',
            'xml' => 'nullable|mimes:xml',
        ];
    }
}
