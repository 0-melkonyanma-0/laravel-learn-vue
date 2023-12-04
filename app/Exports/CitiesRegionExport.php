<?php

declare(strict_types= 1);

namespace App\Exports;


use App\Exports\Sheets\CitiesSheet;
use App\Exports\Sheets\RegionsSheet;
use Illuminate\Support\Facades\App;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class CitiesRegionExport implements
    WithMultipleSheets,
    ShouldQueue
{
    use Exportable;

    public function sheets(): array
    {
        App::setLocale('ru');

        return [
            new CitiesSheet(),
            new RegionsSheet(),
        ];
    }
}
