<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssetRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'unit_id' => ['required'],
            'sub_cluster_id' => ['required'],
            'member_name' => ['required'],
            'pic' => ['required'],
            'activity' => ['required'],
            'asset_location' => ['required'],
            'kondisi' => ['required'],
            'uom' => ['required'],
            'quantity' => ['required'],
            'tgl_bast' => ['required'],
            'hm' => ['required'],
            'pr_number' => ['required'],
            'po_number' => ['required'],
            'gr_number' => ['required'],
            'remark' => ['required'],
            'status' => ['required'],
        ];
    }
}