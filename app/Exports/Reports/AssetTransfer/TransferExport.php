<?php

namespace App\Exports\Reports\AssetTransfer;

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
            $row->kode,
        ];
    }

    public function headings(): array
    {
        return  [
            'Id Asset',
        ];
    }

    public function title(): string
    {
        return 'asset-transfers';
    }
}
