<?php

declare(strict_types=1);

namespace App\Imports;

use App\Imports\Sheets\RegionsSheet;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class RegionsImport implements
    WithMultipleSheets,
    WithChunkReading,
    ShouldQueue
{
    public function sheets(): array
    {
        return [
            __('regions') => new RegionsSheet()
        ];
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
