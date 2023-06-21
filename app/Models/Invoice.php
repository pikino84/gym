<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    protected $fillable = ['id_invoice', 'id_user', 'description', 'monto', 'id_status', 'pdf', 'xml'];

    public function validar()
    {
        return [
            'idproveedor' => 'required',
            'id_invoice' => 'required|unique:proveedores',
            'description' => 'required',
            'monto' => 'required|numeric',
            'status' => 'integer',
            'pdf' => 'nullable|mimes:pdf',
            'xml' => 'nullable|mimes:xml',
        ];
    }
}
