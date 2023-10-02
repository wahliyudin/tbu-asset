<?php

namespace App\Jobs\Assets;

use App\DataTransferObjects\Masters\LeasingData;
use App\Facades\Assets\AssetService as AssetsAssetService;
use App\Helpers\CarbonHelper;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Project;
use App\Services\Assets\AssetLeasingService;
use App\Services\Assets\AssetService;
use App\Services\Assets\AssetUnitService;
use App\Services\Masters\ActivityService;
use App\Services\Masters\CategoryService;
use App\Services\Masters\ClusterService;
use App\Services\Masters\ConditionService;
use App\Services\Masters\LeasingService;
use App\Services\Masters\LifetimeService;
use App\Services\Masters\SubClusterService;
use App\Services\Masters\UnitService;
use App\Services\Masters\UomService;
use Carbon\Carbon;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

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

            $category = CategoryService::store([
                'id' => $val['kode_asset_category'],
                'name' => $val['asset_category']
            ]);



            $cluster = ClusterService::store([
                'id' => $val['kode_asset_cluster'],
                'name' => $val['asset_cluster'],
                'category_id' => $category?->getKey()
            ]);

            $subCluster = SubClusterService::store([
                'id' => $val['kode_asset_sub_cluster'],
                'name' => $val['asset_sub_cluster'],
                'cluster_id' => $cluster?->getKey()
            ]);



            $unit = UnitService::store([
                'prefix' => isset($val['kode_unit_model']) ? $val['kode_unit_model'] : null,
                'model' => isset($val['unit_model']) ? $val['unit_model'] : null,
            ]);

            $assetUnit = AssetUnitService::store([
                'kode' => isset($val['id_unit']) ? $val['id_unit'] : null,
                'unit_id' => $unit?->getKey(),
                'unit_id_owner' => null,
                'type' => isset($val['unit_type']) ? $val['unit_type'] : null,
                'seri' => isset($val['seri']) ? $val['seri'] : null,
                'class' => isset($val['unit_class']) ? $val['unit_class'] : null,
                'brand' => isset($val['brand']) ? $val['brand'] : null,
                'serial_number' => isset($val['serial_number']) ? $val['serial_number'] : null,
                'spesification' => isset($val['detail_spesifikasi']) ? $val['detail_spesifikasi'] : null,
                'tahun_pembuatan' => isset($val['tahun_pembuatan']) ? $val['tahun_pembuatan'] : null,
                'kelengkapan_tambahan' => isset($val['kelengkapan_tambahan']) ? $val['kelengkapan_tambahan'] : null,
            ]);


            $uom = (new UomService)->store([
                'name' => isset($val['uom']) ? $val['uom'] : null,
            ]);

            // $dealer = (new DealerService)->store([
            //     'name' => isset($val['suplier_dealer']) ? $val['suplier_dealer'] : null,
            // ]);

            $leasing = (new LeasingService)->store(LeasingData::from(['name' => isset($val['vendor_leasing']) ? $val['vendor_leasing'] : null]));

            $pic = Employee::query()->where('nama_karyawan', $val['pic'])->first();

            $project = Project::query()->where('project', $val['lokasi_asset'])->first();

            $department = Department::query()->where('department_name', $val['departemen'])->first();

            $lifetime = LifetimeService::store([
                'masa_pakai' => $val['masa_pakai']
            ]);

            $activity = ActivityService::store([
                'name' => isset($val['activity']) ? $val['activity'] : null
            ]);

            $condition = ConditionService::store([
                'name' => isset($val['kondisi']) ? $val['kondisi'] : null
            ]);

            $asset = AssetService::store([
                'kode' => isset($val['new_id_asset']) ? $val['new_id_asset'] : null,
                'asset_unit_id' => $assetUnit?->getKey(),
                'sub_cluster_id' => $subCluster?->getKey(),
                'pic' => $pic?->nik,
                'activity_id' => $activity?->getKey(),
                'asset_location' => $project?->project_id,
                'dept_id' => $department?->dept_id,
                'condition_id' => $condition?->getKey(),
                'lifetime_id' => $lifetime?->getKey(),
                'uom_id' => $uom?->getKey(),
                'quantity' => isset($val['jumlah']) ? $val['jumlah'] : null,
                'nilai_sisa' => isset($val['nilai_sisa']) ? (int) $val['nilai_sisa'] : 0,
                'tgl_bast' => CarbonHelper::convertDate($val['tanggal_bast']),
                'hm' => isset($val['hours_meter']) ? $val['hours_meter'] : null,
                'pr_number' => isset($val['pr']) ? $val['pr'] : null,
                'po_number' => isset($val['po']) ? $val['po'] : null,
                'gr_number' => isset($val['gr']) ? $val['gr'] : null,
                'remark' => isset($val['keterangan']) ? $val['keterangan'] : null,
                'status_asset' => isset($val['status']) ? $val['status'] : null,
            ]);

            $tanggal_awal_leasing = CarbonHelper::convertDate($val['tanggal_awal_leasing']);
            $jangka_waktu_leasing = is_int($val['jangka_waktu_leasing']) ? $val['jangka_waktu_leasing'] : null;
            $tanggal_akhir_leasing = null;
            if ($tanggal_awal_leasing && $jangka_waktu_leasing) {
                $tanggal_akhir_leasing = Carbon::parse($tanggal_awal_leasing)->addMonths($jangka_waktu_leasing)->format('Y-m-d');
            }
            $assetLeasing = AssetLeasingService::store([
                'asset_id' => $asset->getKey(),
                'dealer_id' => isset($val['dealer_id']) ? $val['dealer_id'] : null,
                'suplier_dealer' => isset($val['suplier_dealer']) ? $val['suplier_dealer'] : null,
                'leasing_id' => $leasing?->getKey(),
                'harga_beli' => isset($val['nilai_perolehan']) ? $val['nilai_perolehan'] : null,
                'jangka_waktu_leasing' => $jangka_waktu_leasing,
                'tanggal_awal_leasing' => $tanggal_awal_leasing,
                'tanggal_akhir_leasing' => $tanggal_akhir_leasing,
                'tanggal_perolehan' => CarbonHelper::convertDate($val['tanggal_perolehan']),
                'biaya_leasing' => isset($val['biaya_leasing']) ? $val['biaya_leasing'] : null,
                'legalitas' => isset($val['legalitas']) ? $val['legalitas'] : null,
            ]);

            $tglBast = CarbonHelper::convertDate($val['tanggal_bast']);
            if ($asset?->getKey() && $tglBast && $lifetime) {
                $nilaiPerolehan = isset($val['nilai_perolehan']) ? (int) $val['nilai_perolehan'] : 0;
                $depreciations = AssetsAssetService::prepareDeprecation($asset?->getKey(), $lifetime->masa_pakai, $tglBast, $nilaiPerolehan);
                // $depresiasi = AssetDepreciationService::store([
                //     'asset_id' => $asset->getKey(),
                //     'masa_pakai' => isset($val['masa_pakai']) ? $val['masa_pakai'] : null,
                //     'umur_asset' => isset($val['umur_asset']) ? $val['umur_asset'] : null,
                //     'umur_pakai' => isset($val['umur_pakai']) ? $val['umur_pakai'] : null,
                //     'depresiasi' => isset($val['depresiasi']) ? $val['depresiasi'] : null,
                //     'sisa' => isset($val['nilai_sisa']) ? $val['nilai_sisa'] : null,
                // ]);
                $asset->depreciations()->createMany($depreciations);
            }

            // $results[] =  [
            //     'kode' => $val['id_asset_existing'],
            //     'unit_id' => $unit?->getKey(),
            //     'sub_cluster_id' => $subCluster?->getKey(),
            //     'member_name' => null,
            //     'pic' => $pic?->nik,
            //     'activity' => $val['activity'],
            //     'asset_location' => $pic?->position?->project?->project,
            //     'kondisi' => $val['kondisi'],
            //     'uom_id' => null,
            //     'quantity' => $val['jumlah'],
            //     'tgl_bast' => Carbon::instance(Date::excelToDateTimeObject($val['tanggal_bast']))->format('Y-m-d'),
            //     'hm' => $val['hm'],
            //     'pr_number' => $val['pr'],
            //     'po_number' => $val['po'],
            //     'gr_number' => $val['gr'],
            //     'remark' => $val['keterangan'],
            //     'status_asset' => $val['status'],
            // ];
        }


        // Asset::query()->upsert($results, 'id');
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
