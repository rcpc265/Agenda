<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVisitorRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'entity' => 'required|string|max:255',
            'dni' => 'nullable|string|size:8',
            'phone_number' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255'
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'nombre',
            'entity' => 'entidad',
            'dni' => 'DNI',
            'phone_number' => 'número de celular',
            'email' => 'correo electrónico'
        ];
    }
}
