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
            // 'member_name' => ['required'],
            // 'pic' => ['required'],
            'activity' => ['required'],
            'asset_location' => ['required', 'integer'],
            'kondisi' => ['required'],
            'uom_id' => ['required'],
            'quantity' => ['required', 'integer'],
            'tgl_bast' => ['required', 'date'],
            'hm' => ['nullable'],
            'pr_number' => ['required'],
            'po_number' => ['required'],
            'gr_number' => ['required'],
            'remark' => ['required'],
            'status' => ['required'],

            'unit_unit_id' => ['required'],
            'unit_kode' => ['required'],
            'unit_type' => ['required'],
            'unit_seri' => ['required'],
            'unit_class' => ['required'],
            'unit_brand' => ['required'],
            'unit_serial_number' => ['required'],
            'unit_spesification' => ['required'],
            'unit_tahun_pembuatan' => ['required'],
            'unit_kelengkapan_tambahan' => ['required'],

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
