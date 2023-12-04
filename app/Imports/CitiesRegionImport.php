<?php

declare(strict_types=1);

namespace App\Imports;

use App\Imports\Sheets\CitiesSheet;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class CitiesRegionImport implements
    WithMultipleSheets,
    WithChunkReading,
    ShouldQueue
{
    public function sheets(): array
    {
        return [
            __('cities') => new CitiesSheet(),
        ];
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
