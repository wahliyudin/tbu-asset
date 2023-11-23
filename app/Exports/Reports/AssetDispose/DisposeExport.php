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
        return 'asset-disposes';
    }
}
