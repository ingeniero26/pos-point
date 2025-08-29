<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AccountPlanRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'account_type' => 'nullable|string|in:asset,liability,equity,income,expense',
            'search' => 'nullable|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'account_type.in' => 'El tipo de cuenta no es válido.',
            'search.max' => 'La búsqueda no puede exceder los 255 caracteres.',
        ];
    }
}
