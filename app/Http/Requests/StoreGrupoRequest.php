<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGrupoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function rules(): array
    {
        return [
            'grado' => ['required', 'string', 'max:255'],
            'grupo' => ['required', 'string', 'max:255'],
            'profesor_id' => ['required'],
           
        ];
    }

    public function messages()
    {
        return [
            'grado.required' => 'El campo Grado es obligatorio.',
            'grupo.required' => 'El campo Grupo es obligatorio.',
            'profesor_id' => 'El campo Profesor es obligatorio.',
            
        ];
    }
}
