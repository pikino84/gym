<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EstadoDeCuenteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id_fac_compac' => 'required|unique:tu_tabla',
            'nombre_proveedor' => 'required',
            'descripcion' => 'required',
            'monto' => 'required|numeric',
            'status' => 'integer',
            'pdf' => 'nullable|mimes:pdf',
            'xml' => 'nullable|mimes:xml',
        ];
    }
}
