<?php

namespace App\Exports\Reports\AssetTransfer;

use App\Helpers\CarbonHelper;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class TransferExport implements FromCollection, WithMapping, WithTitle, ShouldAutoSize, WithHeadings
{
    public function __construct(
        protected Collection $assetTransfers
    ) {
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->assetTransfers;
    }

    public function map($row): array
    {
        return [
            $row->no_transaksi,
            $row->employee?->nama_karyawan,
            $row->asset?->kode,
            $row->oldProject?->project,
            $row->oldPic?->nama_karyawan,
            $row->old_location,
            $row->old_divisi,
            $row->old_department,
            $row->newProject?->project,
            $row->newPic?->nama_karyawan,
            $row->new_location,
            $row->new_divisi,
            $row->new_department,
            CarbonHelper::dateFormatdFY($row->request_transfer_date),
            $row->justifikasi,
            $row->remark,
            $row->note,
            CarbonHelper::dateFormatdFY($row->transfer_date),
            CarbonHelper::dateFormatdFY($row->tanggal_bast),
            $row->no_bast,
            asset("storage/{$row->file_bast}"),
            $row->status?->label(),
        ];
    }

    public function headings(): array
    {
        return  [
            'No Transfer',
            'Employee',
            'Kode Asset',
            'Old Project',
            'Old PIC',
            'Old Location',
            'Old Divisi',
            'Old Department',
            'New Project',
            'New PIC',
            'New Location',
            'New Divisi',
            'New Department',
            'Tanggal Pemindahan',
            'Justifikasi',
            'Remark',
            'Note',
            'Transfer Date',
            'Tanggal BAST',
            'No BAST',
            'File BAST',
            'Status',
        ];
    }

    public function title(): string
    {
        return 'asset-transfers';
    }
}
