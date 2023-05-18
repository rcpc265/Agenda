<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVisitRequest extends FormRequest
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
            'subject' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'code' => 'required|string|max:255',
            'status' => 'nullable|in:Pendiente,Confirmado,Cancelado',
            'office_name' => 'required|string|max:255',
            'visitor_id' => 'required|exists:visitors,id',
            'user_id' => 'required|integer|exists:users,id',
        ];
    }

    public function attributes()
    {
        return [
            'subject' => 'asunto',
            'name' => 'nombre',
            'start_date' => 'fecha de inicio',
            'end_date' => 'fecha de finalización',
            'code' => 'cargo',
            'status' => 'estado',
            'office_name' => 'nombre de la oficina',
            'visitor_id' => 'visitante',
            'user_id' => 'user'
        ];
    }

    public function messages()
    {
        return [
            'visitor_id.exists' => 'Seleccione un visitante.',
        ];
    }
}
