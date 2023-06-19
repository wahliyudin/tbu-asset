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
            'unit_id' => ['required', 'exists:units,id'],
            'sub_cluster_id' => ['required', 'exists:sub_clusters,id'],
            'member_name' => ['required'],
            'pic' => ['required', 'integer'],
            'activity' => ['required'],
            'asset_location' => ['required', 'integer'],
            'kondisi' => ['required'],
            'uom' => ['required'],
            'quantity' => ['required', 'integer'],
            'tgl_bast' => ['required', 'date'],
            'hm' => ['required'],
            'pr_number' => ['required'],
            'po_number' => ['required'],
            'gr_number' => ['required'],
            'remark' => ['required'],
            'status' => ['required'],
        ];
    }
}
