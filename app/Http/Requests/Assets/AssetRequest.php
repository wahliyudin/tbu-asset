<?php

namespace App\Http\Requests\Assets;

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
            'kode' => ['required'],
            'unit_id' => ['required', 'exists:units,id'],
            'sub_cluster_id' => ['required', 'exists:sub_clusters,id'],
            'pic' => ['required'],
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

            'dealer_id_leasing' => ['required'],
            'leasing_id_leasing' => ['required'],
            'harga_beli_leasing' => ['required'],
            'jangka_waktu_leasing' => ['required'],
            'biaya_leasing' => ['required'],
            'legalitas_leasing' => ['required'],

            'jangka_waktu_insurance' => ['required'],
            'biaya_insurance' => ['required'],
            'legalitas_insurance' => ['required'],
        ];
    }
}
