<?php

namespace App\Exports\Reports\Cer;

use App\Helpers\CarbonHelper;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class CerExport implements FromCollection, WithMapping, WithTitle, ShouldAutoSize, WithHeadings
{
    public function __construct(
        protected Collection $cers
    ) {
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->cers;
    }

    public function map($row): array
    {
        return [
            $row->no_cer,
            $row->employee?->nama_karyawan,
            $row->type_budget?->label(),
            $row->department?->department_name,
            $row->budget_ref,
            $row->peruntukan?->label(),
            CarbonHelper::dateFormatdFY($row->tgl_kebutuhan),
            $row->justifikasi,
            $row->sumber_pendanaan?->label(),
            $row->cost_analyst,
            $row->note,
            url($row->file_ucr),
            $row->status_pr,
            $row->status?->label(),
        ];
    }

    public function headings(): array
    {
        return  [
            'No Cer',
            'Employee',
            'Tipe Budger',
            'Department',
            'Budget Ref',
            'Peruntukkan',
            'Tanggal Kebutuhan',
            'Justifikasi',
            'Sumber Pendanaan',
            'Cost Analyst',
            'Note',
            'File UCR',
            'Status PR',
            'Status',
        ];
    }

    public function title(): string
    {
        return 'cers';
    }
}
