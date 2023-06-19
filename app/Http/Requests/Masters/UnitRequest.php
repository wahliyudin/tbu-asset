<?php

namespace App\Http\Requests\Masters;

use Illuminate\Foundation\Http\FormRequest;

class UnitRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'model' => ['required'],
            'type' => ['required'],
            'seri' => ['required'],
            'class' => ['required'],
            'brand' => ['required'],
            'serial_number' => ['required'],
            'spesification' => ['required'],
            'tahun_pembuatan' => ['required', 'date_format:Y'],
        ];
    }
}