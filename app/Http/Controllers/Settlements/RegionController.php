<?php

declare(strict_types=1);

namespace App\Http\Controllers\Settlements;

use App\Http\Controllers\Controller;
use App\Services\Settlements\RegionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;

class RegionController extends Controller
{
    protected RegionService $regionService;

    public function __construct(RegionService $regionService)
    {
        $this->regionService = $regionService;
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
}
