<?php

declare(strict_types=1);

namespace App\Exports\Sheets;

use App\Models\Settlements\Region;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class CitiesSheet implements
    FromCollection,
    WithTitle,
    ShouldAutoSize,
    WithHeadings,
    ShouldQueue
{
    public function collection(): Collection
    {
        $exportData = new Collection();
        $citiesByRegion = Region::with('cities')->get();

        $citiesByRegion->each(function ($region) use ($exportData) {
            $region->cities->each(function ($city) use ($region, $exportData) {
                $exportData->push(['title' => $city->title, 'region' => $region->title]);
            });
        });

        return $exportData;
    }

    public function title(): string
    {
        return __("cities");
    }

    public function headings(): array
    {
        return [__('city'), __('region')];
    }
}
