<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
                'id_user' => 'required',
                'id_invoice' => 'required|unique:invoices',
                'description' => 'required',
                'monto' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'id_user.required' => 'El Proveedor es requerido',
            'id_invoice.required' => 'El ID de la factura es requerido',
            'description.required' => 'La descripción es requerida',
            'monto.required' => 'El monto es requerido',
        ];
    }
}
