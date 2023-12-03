<?php

declare(strict_types= 1);

namespace App\Helpers;

use Maatwebsite\Excel\Excel;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ConvertFiles {
    public function xlsToXLSX(string $filePath): string
    {
        $spreadsheet = IOFactory::load($filePath);
        $objSpreadsheet = IOFactory::createWriter($spreadsheet, Excel::XLSX);

        //$part = explode('/', $filePath);
        //Storage::disk('local')->delete(sprintf('temp/%s', end($part)));

        $filePath = str_replace('.xls', '.xlsx', $filePath);
        $objSpreadsheet->save($filePath);

        return $filePath;
    }
}
