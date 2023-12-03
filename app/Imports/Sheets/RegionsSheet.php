<?php

declare(strict_types=1);

namespace App\Imports\Sheets;

use App\Models\Settlements\Region;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class RegionsSheet implements
    ToModel,
    WithHeadingRow
{
    public function model(array $row): void
    {
        if ($row['region'] !== null) {
            Region::firstOrCreate([
                'title' => $row['region']
            ]);
        }
    }
}
