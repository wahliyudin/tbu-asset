<?php

namespace App\Http\Requests\Transfers;

use Illuminate\Foundation\Http\FormRequest;

class AssetTransferRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'no_transaksi' => ['required'],
            'nik' => ['required'],
            'old_pic' => ['required'],
            'old_location' => ['required'],
            'old_divisi' => ['required'],
            'old_department' => ['required'],
            'new_pic' => ['required'],
            'new_location' => ['required'],
            'new_divisi' => ['required'],
            'new_department' => ['required'],
            'request_transfer_date' => ['required'],
            'justifikasi' => ['required'],
            'remark' => ['required'],
            'transfer_date' => ['required'],
        ];
    }
}