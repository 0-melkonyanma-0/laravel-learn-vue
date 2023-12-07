<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\Controller;
use App\Services\Event\StatisticService;
use Illuminate\Support\Collection;

class StatisticController extends Controller
{
    protected StatisticService $statisticService;

    public function __construct(StatisticService $statisticService)
    {
        $this->statisticService = $statisticService;
    }

    public function index(): Collection
    {
        return $this->statisticService->getStatistics();
    }
}
