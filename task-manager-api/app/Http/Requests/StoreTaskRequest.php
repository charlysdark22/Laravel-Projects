<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTaskRequest extends FormRequest
{
    public function authorize()
    {
        return true; // En producción, usa policies
    }

    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'keyword_ids' => 'array',
            'keyword_ids.*' => 'exists:keywords,id',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'El título es obligatorio.',
            'keyword_ids.*.exists' => 'Una o más palabras clave no existen.',
        ];
    }
}