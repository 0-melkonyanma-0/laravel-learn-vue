<?php

declare(strict_types=1);

namespace App\Http\Controllers\Settlements;

use App\Http\Controllers\Controller;
use App\Services\Settlements\CityService;

class CityController extends Controller
{
    protected CityService $cityService;

    public function __construct(CityService $cityService)
    {
        $this->cityService = $cityService;
    }

    public function index()
    {
        return $this->cityService->getAll();
    }

    public function destroy(int $id)
    {
        $this->cityService->delete($id);

        return response()->json(['message' => __('success_deleted')]);
    }
}
