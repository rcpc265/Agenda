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
            'status' => 'required|in:pending,confirmed,canceled',
            'office_name' => 'required|string|max:255'
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
            'office_name' => 'nombre de la oficina'
        ];
    }
}
