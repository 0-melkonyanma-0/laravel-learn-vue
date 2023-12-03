<?php

declare(strict_types=1);

namespace App\Services\Settlements;

use App\Models\Settlements\City;
use App\Models\Settlements\Region;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class CityService
{
    public function getAll(): Collection
    {
        return City::all();
    }

    public function delete(int $id): void
    {
        City::find($id)->delete();
    }

    public function createCitiesByRegion(): void
    {
        $response = $this->getCitiesByRegion();

        $response->each(function ($data, $key) {
            $region = Region::firstOrCreate(['title' => $data['region']]);

            $region->cities()->firstOrCreate([
                'region_id' => $region->id,
                'title' => $data['city'],
            ]);
        });
    }

    protected function getCitiesByRegion(): Collection
    {
        $url = 'https://gist.githubusercontent.com/gorborukov/0722a93c35dfba96337b/raw';

        return collect(Http::get($url)->json());
    }
}
