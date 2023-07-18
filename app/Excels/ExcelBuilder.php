<?php

namespace App\Excels;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

abstract class ExcelBuilder
{
    public function resolver()
    {
        $spreadsheet = new Spreadsheet();
        $asset = $spreadsheet->getActiveSheet();
        $master = $spreadsheet->addSheet(new Worksheet($spreadsheet));
    }

    public abstract function columnsDataValidations(): array;

    public abstract function headers(): array;
}
