<?php

declare(strict_types=1);

namespace App\Http\Controllers\Settlements;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settlements\CitiesByRegionRequest;
use App\Services\Settlements\CityService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;

class CityController extends Controller
{
    protected CityService $cityService;

    public function __construct(CityService $cityService)
    {
        $this->cityService = $cityService;
    }

    public function index(): Collection
    {
        return $this->cityService->getAll();
    }

    public function destroy(int $id): JsonResponse
    {
        $this->cityService->delete($id);

        return response()->json(['message' => __('success_deleted')]);
    }

    public function import(CitiesByRegionRequest $request): JsonResponse
    {
        $this->cityService->import(collect($request->validated()));

        return response()->json(['message' => __('start_importing')]);
    }
}
