<?php

namespace App\Exports\Reports\AssetMaster;

use App\Helpers\CarbonHelper;
use App\Helpers\Helper;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class AssetExport implements FromCollection, WithMapping, WithTitle, ShouldAutoSize, WithHeadings
{
    public function __construct(
        protected Collection $assets
    ) {
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->assets;
    }

    public function map($row): array
    {
        return [
            $row->kode,
            $row->assetUnit?->kode,
            $row->assetUnit?->type,
            $row->assetUnit?->seri,
            $row->assetUnit?->class,
            $row->assetUnit?->brand,
            $row->assetUnit?->serial_number,
            $row->assetUnit?->spesification,
            $row->assetUnit?->tahun_pembuatan,
            $row->assetUnit?->kelengkapan_tambahan,
            $row->subCluster?->cluster?->category?->name,
            $row->subCluster?->cluster?->name,
            $row->subCluster?->name,
            $row->employee?->nama_karyawan,
            $row->activity?->name,
            $row->project?->project,
            $row->department?->department_name,
            $row->condition?->name,
            $row->uom?->name,
            $row->quantity,
            $row->lifetime?->masa_pakai,
            Helper::formatRupiah($row->nilai_sisa),
            CarbonHelper::dateFormatdFY($row->tgl_bast),
            $row->hm,
            $row->pr_number,
            $row->po_number,
            $row->pr_number,
            $row->status_asset,
            $row->status?->label(),
            $row->remark,

            $row->leasing?->dealer?->name,
            Helper::formatRupiah($row->leasing?->harga_beli),
            $row->leasing?->jangka_waktu_leasing,
            CarbonHelper::dateFormatdFY($row->leasing?->tanggal_awal_leasing),
            CarbonHelper::dateFormatdFY($row->leasing?->tanggal_akhir_leasing),
            Helper::formatRupiah($row->leasing?->biaya_leasing),
            $row->leasing?->legalitas,
            CarbonHelper::dateFormatdFY($row->leasing?->tanggal_perolehan),

            $row->insurance?->jangka_waktu,
            Helper::formatRupiah($row->insurance?->biaya),
            $row->insurance?->legalitas,
            CarbonHelper::dateFormatdFY($row->insurance?->tanggal_awal),
            CarbonHelper::dateFormatdFY($row->insurance?->tanggal_akhir),
        ];
    }

    public function headings(): array
    {
        return  [
            'Id Asset',
            'Kode Unit',
            'Type',
            'Seri',
            'Class',
            'Brand',
            'Serial Number',
            'Spesification',
            'Tahun Pembuatan',
            'Kelengkapan Tambahan',
            'Category',
            'Cluster',
            'Sub Cluster',
            'PIC',
            'Activity',
            'Asset Location',
            'Department',
            'Condition',
            'Uom',
            'Quantity',
            'Masa Pakai',
            'Nilai Sisa',
            'Tanggal BAST',
            'HM',
            'PR Number',
            'PO Number',
            'GR Number',
            'Status Asset',
            'Status',
            'Remark',

            'Dealer',
            'Harga Beli Leasing',
            'Jangka Waktu Leasing',
            'Tanggal Awal Leasing',
            'Tanggal Akhir Leasing',
            'Biaya Leasing',
            'Nomor Kontrak',
            'Tanggal Perolehan',

            'Jangka Waktu Asuransi',
            'Biaya Asuransi',
            'Nomor Asuransi',
            'Tanggal Awal Asuransi',
            'Tanggal Akhir Asuransi',
        ];
    }

    public function title(): string
    {
        return 'assets';
    }
}
