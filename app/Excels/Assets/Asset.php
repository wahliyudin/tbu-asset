<?php

namespace App\Excels\Assets;

use App\Enums\Asset\Status;
use App\Models\Masters\SubCluster;
use App\Models\Masters\Unit;
use App\Models\Masters\Uom;
use App\Services\GlobalService;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class Asset
{
    public function generate()
    {
        $spreadsheet = new Spreadsheet();
        $asset = $spreadsheet->getActiveSheet();
        $master = $spreadsheet->addSheet(new Worksheet($spreadsheet));

        $master->setTitle('master');
        $asset->setTitle('asset');

        $titles = [
            'Unit',
            'Sub Cluster',
            'Member Name',
            'PIC',
            'Activity',
            'Asset Location',
            'Kondisi',
            'UOM',
            'Quantity',
            'Tgl Bast',
            'HM',
            'PR Number',
            'PO Number',
            'GR Number',
            'Remark',
            'Status',
        ];
        $h = 'A';
        foreach ($titles as $i => $val) {
            $asset->setCellValue($h . '1', $val);
            $h = $this->incrementLetter($h);
        }

        $columnIterator = $asset->getColumnIterator();
        foreach ($columnIterator as $column) {
            $dimension = $asset->getColumnDimension($column->getColumnIndex());
            $dimension->setWidth(20);
        }

        $master->getStyle('A1:G1')
            ->getFont()
            ->setBold(true);
        $asset->getStyle('A1:P1')
            ->getFont()
            ->setBold(true);


        $master->setCellValue('A1', 'Unit');
        $master->getColumnDimension('A')->setAutoSize(true);
        $data = Unit::query()->pluck('model')->toArray();
        $dropdownRange = '$A$2:$A$' . (count($data) + 2);
        foreach ($data as $index => $item) {
            $cell = 'A' . ($index + 2);
            $master->setCellValue($cell, $item);
        }
        $dataValidation = $asset->getCell('A2')->getDataValidation();
        $dataValidation->setType(DataValidation::TYPE_LIST)
            ->setAllowBlank(true)
            ->setShowDropDown(true)
            ->setFormula1('=master!' . $dropdownRange);
        $asset->setDataValidation('A2:A10', $dataValidation);

        $master->setCellValue('C1', 'Sub Cluster');
        $master->getColumnDimension('C')->setAutoSize(true);
        $data = SubCluster::query()->pluck('name')->toArray();
        $dropdownRange = '$C$2:$C$' . (count($data) + 2);
        foreach ($data as $index => $item) {
            $cell = 'C' . ($index + 2);
            $master->setCellValue($cell, $item);
        }
        $dataValidation = $asset->getCell('B2')->getDataValidation();
        $dataValidation->setType(DataValidation::TYPE_LIST)
            ->setAllowBlank(true)
            ->setShowDropDown(true)
            ->setFormula1('=master!' . $dropdownRange);
        $asset->setDataValidation('B2:B10', $dataValidation);

        $master->setCellValue('E1', 'UOM');
        $master->getColumnDimension('E')->setAutoSize(true);
        $data = Uom::query()->pluck('name')->toArray();
        $dropdownRange = '$E$2:$E$' . (count($data) + 2);
        foreach ($data as $index => $item) {
            $cell = 'E' . ($index + 2);
            $master->setCellValue($cell, $item);
        }
        $dataValidation = $asset->getCell('H2')->getDataValidation();
        $dataValidation->setType(DataValidation::TYPE_LIST)
            ->setAllowBlank(true)
            ->setShowDropDown(true)
            ->setFormula1('=master!' . $dropdownRange);
        $asset->setDataValidation('H2:H10', $dataValidation);

        $master->setCellValue('G1', 'Status');
        $master->getColumnDimension('G')->setAutoSize(true);
        $data = collect(Status::cases())->pluck('value')->toArray();
        $dropdownRange = '$G$2:$G$' . (count($data) + 2);
        foreach ($data as $index => $item) {
            $cell = 'G' . ($index + 2);
            $master->setCellValue($cell, $item);
        }
        $dataValidation = $asset->getCell('P2')->getDataValidation();
        $dataValidation->setType(DataValidation::TYPE_LIST);
        $dataValidation->setAllowBlank(true);
        $dataValidation->setShowDropDown(true);
        $dataValidation->setFormula1('=master!' . $dropdownRange);
        $asset->setDataValidation('P2:P10', $dataValidation);

        $master->setCellValue('I1', 'PIC');
        $master->getColumnDimension('I')->setAutoSize(true);
        $data = GlobalService::getEmployees(['nama_karyawan'])->toCollection()->pluck('nama_karyawan')->toArray();
        $dropdownRange = '$I$2:$I$' . (count($data) + 2);
        foreach ($data as $index => $item) {
            $cell = 'I' . ($index + 2);
            $master->setCellValue($cell, $item);
        }
        $dataValidation = $asset->getCell('D2')->getDataValidation();
        $dataValidation->setType(DataValidation::TYPE_LIST);
        $dataValidation->setAllowBlank(true);
        $dataValidation->setShowDropDown(true);
        $dataValidation->setFormula1('=master!' . $dropdownRange);
        $asset->setDataValidation('D2:D10', $dataValidation);

        $asset->getStyle('J1:J10')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
        $master->setSheetState('hidden');

        $writer = new Xlsx($spreadsheet);
        $writer->save('assets/template-import/asset.xlsx');
        return 'assets/template-import/asset.xlsx';
    }

    public function incrementLetter($letter)
    {
        $ascii = ord($letter);
        $ascii++;
        $newLetter = chr($ascii);
        return $newLetter;
    }
}
