<?php

namespace App\Http\Requests\Cers;

use Illuminate\Foundation\Http\FormRequest;

class CerRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $rules = [
            'peruntukan' => ['required'],
            'type_budget' => ['required'],
            'tgl_kebutuhan' => ['required'],
            'justifikasi' => ['required'],
            'items' => ['array'],
            'sumber_pendanaan' => ['required'],
            'budget_ref' => ['required'],
            'cost_analyst' => ['required'],
        ];
        foreach (request()->get('items') ?? [] as $key => $value) {
            $rules['items.' . $key . '.description'] = ['required', 'string'];
            $rules['items.' . $key . '.model'] = ['required', 'string'];
            $rules['items.' . $key . '.est_umur'] = ['required', 'numeric'];
            $rules['items.' . $key . '.qty'] = ['required', 'numeric'];
            $rules['items.' . $key . '.price'] = ['required'];
            $rules['items.' . $key . '.uom'] = 'nullable';
        }
        return $rules;
    }
}
