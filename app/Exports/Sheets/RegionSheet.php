<?php

declare(strict_types=1);

namespace App\Exports\Sheets;

use App\Models\Settlements\Region;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class RegionSheet implements
    FromCollection,
    WithTitle,
    ShouldAutoSize,
    WithHeadings
{
    public function collection(): Collection
    {
        return Region::all('title');
    }

    public function title(): string
    {
        return __("regions");
    }
    public function headings(): array
    {
        return [__('region')];
    }
}
