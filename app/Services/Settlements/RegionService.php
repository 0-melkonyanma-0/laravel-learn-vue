<?php

declare(strict_types=1);

namespace App\Services\Settlements;

use App\Helpers\ConvertFiles;
use App\Jobs\ImportRegionJob;
use App\Models\Settlements\Region;
use Illuminate\Support\Collection;

class RegionService
{
    public function getAll(): Collection
    {
        return Region::all();
    }

    public function delete(int $id): void
    {
        Region::find($id)->delete();
    }

    public function import(Collection $array): void
    {
        $path = $array['excel_file']->store('temp');
        $filePath = sprintf('%s/%s', storage_path('app'), $path);

        if (!stristr($filePath, '.xlsx')) {
            $filePath = (new ConvertFiles())->xlsToXLSX($filePath);
        }

        ImportRegionJob::dispatch($filePath);
    }
}
