<?php

namespace App\Exports\Reports\AssetDispose;

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
            $row->asset_id,
            $row->no_dispose,
            $row->nik,
            $row->nilai_buku,
            $row->est_harga_pasar,
            $row->notes,
            $row->justifikasi,
            $row->pelaksanaan,
            $row->remark,
            $row->note,
            $row->status,
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
