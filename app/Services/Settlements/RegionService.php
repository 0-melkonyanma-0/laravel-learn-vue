<?php

declare(strict_types=1);

namespace App\Services\Settlements;

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
}
