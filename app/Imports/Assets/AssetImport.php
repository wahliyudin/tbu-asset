<?php

namespace App\Imports\Assets;

use App\DataTransferObjects\Masters\CategoryData;
use App\DataTransferObjects\Masters\ClusterData;
use App\DataTransferObjects\Masters\SubClusterData;
use App\DataTransferObjects\Masters\UnitData;
use App\Enums\Asset\Status;
use App\Facades\Assets\AssetService;
use App\Models\Masters\SubCluster;
use App\Models\Masters\Unit;
use App\Models\Masters\Uom;
use App\Services\GlobalService;
use App\Services\Masters\CategoryService;
use App\Services\Masters\ClusterService;
use App\Services\Masters\SubClusterService;
use App\Services\Masters\UnitService;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class AssetImport implements ToArray, WithHeadingRow
{
    /**
     * @param array $data
     */
    public function array(array $data)
    {
        foreach ($data as $i => $val) {
            if ($val['id_asset_existing'] == null) {
                unset($data[$i]);
            }
        }
        $results = [];
        foreach ($data as $val) {
            $category = CategoryService::store(CategoryData::from(['name' => $val['asset_category']]));
            $cluster = ClusterService::store(ClusterData::from(['name' => $val['asset_cluster'], 'category_id' => $category->getKey()]));
            $subCluster = SubClusterService::store(SubClusterData::from(['name' => $val['asset_sub_cluster'], 'cluster_id' => $cluster->getKey()]));
            $unit = UnitService::store(UnitData::fromImport($val));
            array_push($results, [
                'kode' => Str::random(),
                'unit_id' => $unit->getKey(),
                'sub_cluster_id' => $subCluster->getKey(),
                'pic' => GlobalService::getEmployeeByNamaKaryawan($val['p_i_c'])?->nik,
                'activity' => $val['activity'],
                'asset_location' => null,
                'kondisi' => $val['kondisi'],
                'uom_id' => null,
                'quantity' => $val['jumlah'],
                'tgl_bast' => Carbon::instance(Date::excelToDateTimeObject($val['tanggal_bast']))->format('Y-m-d'),
                'hm' => null,
                'pr_number' => $val['pr'],
                'po_number' => $val['po'],
                'gr_number' => $val['gr'],
                'remark' => $val['keterangan'],
                'status' => null,
            ]);
        }
        AssetService::import($results);
    }

    private function validate($data)
    {
        $rules = [
            '*.unit' => ['required', 'exists:units,model'],
            '*.sub_cluster' => ['required', 'exists:sub_clusters,name'],
            '*.pic' => 'required',
            '*.activity' => 'required',
            '*.asset_location' => 'required',
            '*.kondisi' => 'required',
            '*.uom' => ['required', 'exists:uoms,name'],
            '*.quantity' => 'required',
            '*.tgl_bast' => 'required',
            '*.hm' => 'required',
            '*.pr_number' => 'required',
            '*.po_number' => 'required',
            '*.gr_number' => 'required',
            '*.remark' => 'required',
            '*.status' => ['required', 'in:' . implode(',', collect(Status::cases())->pluck('value')->toArray())],
        ];
        $validator = Validator::make($data, $rules);
        $validator->setException(ValidationException::withMessages($this->transform($validator->getMessageBag())));
        return $validator->valid();
    }

    public function transform(MessageBag $messages)
    {
        $results = [];
        foreach ($messages->getMessages() as $key => $value) {
            $keys = str($key)->explode('.');
            $field = ucwords(str(isset($keys[1]) ? $keys[1] : '')->replace('_', ' ')->value());
            $i = (isset($keys[0]) ? $keys[0] : 0) + 1;
            $results = array_merge($results, [$key => [
                $field . " baris ke-" . $i . str($value[0])->remove($key)->value()
            ]]);
        }
        return $results;
    }

    private function umur_pakai_on_hire_bulan($tglBast = null)
    {
        // [
        //     "no" => 1,
        //     "asset_category" => "EQUIPMENT",

        //     "asset_cluster" => "MAIN EQUIPMENT",

        //     "asset_sub_cluster" => "DIGGER",

        //     "id_asset_existing" => "10-18-PLT-EX-2009",
        //     "new_id_asset" => "10-18-ENG-EX-2009",

        //     "id_unit" => "EX-2009",
        //     "unit_model" => "EXCAVATOR",
        //     "unit_type" => 330,
        //     "seri" => "D2L",
        //     "unit_class" => "30 TON",
        //     "unit_merk_brand" => "CATERPILLAR",
        //     "serial_number" => "SZK10972",
        //     "detail_spesifikasi" => "Engine C7.1 Hyd. Excavator Cap. 30 Ton ",
        //     "tahun_pembuatan" => 2018,

        //     "nilai_perolehan_harga_beli" => 337500000,
        //     "vendor_leasing" => "PT. Wargi santosa",
        //     "jangka_waktu_leasing_sewa" => 44374,
        //     "biaya_leasing_sewa_perbulan" => 0,
        //     "legalitas" => "Invoice & faktur",

        //     "p_i_c" => "Tulis Hari S",
        //     "lokasi_asset" => "Ex. TBU-BEL, TBU-TAI",
        //     "kondisi" => "RFU",
        //     "uom" => "Unit",
        //     "activity" => "COAL",
        //     "jumlah" => 1,
        //     "tanggal_bast" => 43279,
        //     "gr" => null,
        //     "pr" => null,
        //     "po" => null,
        //     "keterangan" => "Sudah dibeli TBU 100%",
        //     "status" => "OWNED", // status_asset

        //     "masa_pakai_asset_bulan" => 36,
        //     "umur_asset" => '=IFERROR(IF(R2="","",DATEDIF(R2,TODAY(),"M")+1),0)',
        //     "umur_pakai_on_hire_bulan" => '=IFERROR(IF(V2="","",DATEDIF(V2,TODAY(),"M")+1),0)',
        //     "depresiasi" => '=IFERROR(S2/$AL2,"")',
        //     "nilai_sisa" => "=IF(AK2>=AL2,0,(AL2-AK2)*AM2)",

        //     "suplier_dealer_toko" => "PT TRAKINDO UTAMA",

        //     "kelengkapan_tambahan" => "SKAT",
        //     "tanggal_perolehan" => 43272,
        //     "tanggal_bast_2" => 44552,
        //     "hours_meter_kilo_meter" => null,
        //     "departemen" => "PRODUCTION",
        // ];
        // IF(tanggal_bast="","",DATEDIF(tanggal_bast,TODAY(),"M")+1)
        if (!$tglBast) {
            return null;
        }
        return Carbon::make($tglBast)->diffInMonths(now()) + 1;
    }
}
