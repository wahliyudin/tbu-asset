<?php

namespace App\Exports\Reports\AssetDispose;

use App\Helpers\Helper;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class DisposeExport implements FromCollection, WithMapping, WithTitle, ShouldAutoSize, WithHeadings
{
    public function __construct(
        protected Collection $data
    ) {
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->data;
    }

    public function map($row): array
    {
        return [
            $row->no_dispose,
            $row->asset?->kode,
            $row->employee?->nama_karyawan,
            Helper::formatRupiah($row->nilai_buku, true),
            Helper::formatRupiah($row->est_harga_pasar, true),
            $row->notes,
            $row->justifikasi,
            $row->pelaksanaan?->label(),
            $row->remark,
            $row->note,
            $row->status?->label(),
        ];
    }

    public function headings(): array
    {
        return  [
            'No Dispose',
            'Kode Asset',
            'Employee',
            'Nilai Buku',
            'Est. Harga Pasar',
            'Notes',
            'Justifikasi',
            'Pelaksanaan',
            'Remark',
            'Note',
            'Status',
        ];
    }

    public function title(): string
    {
        return 'asset-disposes';
    }
}
