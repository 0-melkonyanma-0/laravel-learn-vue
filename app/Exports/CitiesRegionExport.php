<?php

declare(strict_types= 1);

namespace App\Exports;


use App\Exports\Sheets\CitySheet;
use App\Exports\Sheets\RegionSheet;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class CitiesRegionExport implements
    WithMultipleSheets,
    ShouldQueue
{
    use Exportable;

    public function sheets(): array
    {
        return [
            new CitySheet(),
            new RegionSheet(),
        ];
    }
}
