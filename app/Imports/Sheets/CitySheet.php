<?php

declare(strict_types=1);

namespace App\Imports\Sheets;

use App\Models\Settlements\Region;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CitySheet implements
    ToModel,
    WithHeadingRow
{
    public function model(array $row): void
    {
        if($row['region'] !== null && $row['gorod'] !== null) {
            $region = Region::firstOrCreate([
                'title' => $row['region']
            ]);

            $region->cities()->firstOrCreate([
                'title' => $row['gorod']
            ]);
        }
    }
}
