<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Billing extends FormRequest
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
            'factura_id' => 'integer|required|exists:facturas,id',
            'sucursal_id' => 'integer|required|exists:sucursales,id',
            'credito_fiscal' => 'nullable|sometimes|accepted',
            'numero' => 'integer|required_without:credito_fiscal',
            'amount' => 'numeric|required|min:0',
            'type' => 'integer|required|min:0|max:1',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'factura_id.exists' => 'La factura especificada no existe!',
            'sucursal_id.exists' => 'La sucursal especificada no existe!',
        ];
    }


}
