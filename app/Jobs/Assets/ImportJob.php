<?php

namespace App\Jobs\Assets;

use App\DataTransferObjects\Masters\CategoryData;
use App\DataTransferObjects\Masters\ClusterData;
use App\DataTransferObjects\Masters\SubClusterData;
use App\DataTransferObjects\Masters\UnitData;
use App\Models\Assets\Asset;
use App\Services\Assets\AssetService;
use App\Services\GlobalService;
use App\Services\Masters\CategoryService;
use App\Services\Masters\ClusterService;
use App\Services\Masters\SubClusterService;
use App\Services\Masters\UnitService;
use Carbon\Carbon;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ImportJob implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected array $assets
    ) {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $results = [];
        foreach ($this->assets as $i => $val) {
            $category = CategoryService::store($val['asset_category']);
            $cluster = ClusterService::store(
                $val['asset_cluster'],
                $category?->getKey()
            );
            $subCluster = SubClusterService::store(
                $val['asset_sub_cluster'],
                $cluster?->getKey()
            );
            $unit = UnitService::store([
                'kode' => isset($val['kode']) ? $val['kode'] : null,
                'model' => isset($val['model']) ? $val['model'] : null,
                'type' => isset($val['type']) ? $val['type'] : null,
                'seri' => isset($val['seri']) ? $val['seri'] : null,
                'class' => isset($val['class']) ? $val['class'] : null,
                'brand' => isset($val['brand']) ? $val['brand'] : null,
                'serial_number' => isset($val['serial_number']) ? $val['serial_number'] : null,
                'spesification' => isset($val['spesification']) ? $val['spesification'] : null,
                'tahun_pembuatan' => isset($val['tahun_pembuatan']) ? $val['tahun_pembuatan'] : null,
            ]);
            $pic = GlobalService::getEmployeeByNamaKaryawan($val['p_i_c']);
            $results[] =  [
                'kode' => $val['id_asset_existing'],
                'unit_id' => $unit?->getKey(),
                'sub_cluster_id' => $subCluster?->getKey(),
                'member_name' => isset($val['member_name']) ? $val['member_name'] : null,
                'pic' => $pic?->nik,
                'activity' => $val['activity'],
                'asset_location' => $pic?->position?->project?->project,
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
            ];
        }
        Asset::query()->upsert($results, 'id');
    }

    /**
     * [
     * "no" => 1
     * "asset_category" => "EQUIPMENT"
     * "asset_cluster" => "MAIN EQUIPMENT"
     * "asset_sub_cluster" => "DIGGER"
     * "id_asset_existing" => "10-18-PLT-EX-2009"
     * "new_id_asset" => "10-18-ENG-EX-2009"
     * "id_unit" => "EX-2009"
     * "unit_model" => "EXCAVATOR"
     * "unit_type" => 330
     * "seri" => "D2L"
     * "unit_class" => "30 TON"
     * "activity" => "COAL"
     * "unit_merk_brand" => "CATERPILLAR"
     * "serial_number" => "SZK10972"
     * "detail_spesifikasi" => "Engine C7.1 Hyd. Excavator Cap. 30 Ton "
     * "kelengkapan_tambahan" => "SKAT"
     * "tahun_pembuatan" => 2018
     * "tanggal_perolehan" => 43272
     * "nilai_perolehan_harga_beli" => 337500000
     * "suplier_dealer_toko" => "PT TRAKINDO UTAMA"
     * "vendor_leasing" => "PT. Wargi santosa"
     * "tanggal_bast" => 43279
     * "jumlah" => 1
     * "uom" => "Unit"
     * "lokasi_asset" => "Ex. TBU-BEL, TBU-TAI"
     * "tanggal_bast_2" => 44552
     * "hours_meter_kilo_meter" => null
     * "p_i_c" => "TULIS HARI SETIONO"
     * "departemen" => "PRODUCTION"
     * "kondisi" => "RFU"
     * "status" => "OWNED"
     * "jangka_waktu_leasing_sewa" => 44374
     * "biaya_leasing_sewa_perbulan" => 0
     * "legalitas" => "Invoice & faktur"
     * "umur_pakai_on_hire_bulan" => "=IFERROR(IF(V2="","",DATEDIF(V2,NOW(),"M")+1),0)"
     * "umur_asset" => "=IFERROR(IF(R2="","",DATEDIF(R2,NOW(),"M")+1),0)"
     * "masa_pakai_asset_bulan" => 36
     * "depresiasi" => "=IFERROR(S2/$AL2,"")"
     * "nilai_sisa" => "=IF(AK2>=AL2,0,(AL2-AK2)*AM2)"
     * "gr" => null
     * "pr" => null
     * "po" => null
     * "keterangan" => "Sudah dibeli TBU 100%"
     * ]
     */
}
