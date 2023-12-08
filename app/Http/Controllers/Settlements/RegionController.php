<?php

declare(strict_types=1);

namespace App\Http\Controllers\Settlements;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settlements\CitiesByRegionRequest;
use App\Services\Settlements\CityService;
use App\Services\Settlements\RegionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class RegionController extends Controller
{
    protected RegionService $regionService;
    protected CityService $cityService;

    public function __construct(RegionService $regionService, CityService $cityService)
    {
        $this->regionService = $regionService;
        $this->cityService = $cityService;
    }

    public function index(): Collection
    {
        return $this->regionService->getAll();
    }

    public function destroy(int $id): JsonResponse
    {
        $this->regionService->delete($id);

        return response()->json([['message' => __('success_deleted')]]);
    }

    public function export(): BinaryFileResponse
    {
        return $this->cityService->export();
    }

    public function import(CitiesByRegionRequest $request): JsonResponse
    {
        $this->regionService->import(collect($request->validated()));

        return response()->json(['message' => __('start_importing')]);
    }
}
