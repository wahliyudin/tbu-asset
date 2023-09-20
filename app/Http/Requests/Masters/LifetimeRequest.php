<?php

namespace App\Http\Requests\Masters;

use Illuminate\Foundation\Http\FormRequest;

class LifetimeRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'masa_pakai' => ['required']
        ];
    }
}
