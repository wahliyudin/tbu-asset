<?php

namespace App\Http\Requests\Disposes;

use Illuminate\Foundation\Http\FormRequest;

class AssetDisposeRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'asset' => ['required'],
            'nilai_buku' => ['required'],
            'est_harga_pasar' => ['required'],
            'notes' => ['nullable'],
            'justifikasi' => ['required'],
            'pelaksanaan' => ['required'],
            'remark' => ['required'],
        ];
    }
}
