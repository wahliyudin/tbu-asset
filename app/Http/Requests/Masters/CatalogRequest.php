<?php

namespace App\Http\Requests\Masters;

use Illuminate\Foundation\Http\FormRequest;

class CatalogRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'unit_model' => ['required'],
            'unit_type' => ['required'],
            'seri' => ['required'],
            'unit_class' => ['required'],
            'brand' => ['required'],
            'spesification' => ['required'],
        ];
    }
}