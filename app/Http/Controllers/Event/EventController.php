<?php

declare(strict_types=1);

namespace App\Http\Controllers\Event;

use App\Http\Controllers\Controller;
use App\Http\Requests\Event\EventStoreRequest;
use App\Http\Requests\Event\EventUpdateRequest;
use App\Services\Event\EventService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class EventController extends Controller
{
    protected EventService $eventService;

    public function __construct(EventService $eventService)
    {
        $this->eventService = $eventService;
    }

    public function index(): Collection
    {
        return $this->eventService->getAll();
    }

    public function store(EventStoreRequest $request): JsonResponse
    {
        $this->eventService->save($request->validated());

        return response()->json(['message' => __('success_saved')]);
    }

    public function update(EventUpdateRequest $request, int $id): JsonResponse
    {
        $this->eventService->update($request->validated(), $id);

        return response()->json(['message' => __('success_updated')]);
    }

    public function destroy(int $id): JsonResponse
    {
        $this->eventService->delete($id);

        return response()->json(['message' => __('success_deleted')]);
    }

    public function updateStatus(int $id): JsonResponse
    {
        $this->eventService->updateStatus($id);

        return response()->json(['message' => __('success_updated_status')]);
    }
}
