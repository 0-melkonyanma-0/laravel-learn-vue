<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\JobTitle\JobTitleStoreRequest;
use App\Http\Requests\User\JobTitle\JobTitleUpdateRequest;
use App\Services\User\JobTitleService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;


class JobTitleController extends Controller
{
    protected JobTitleService $jobTitleService;

    public function __construct(JobTitleService $jobTitleService)
    {
        $this->jobTitleService = $jobTitleService;
    }

    public function index(): Collection
    {
        return $this->jobTitleService->getAll();
    }

    public function show(int $id): Collection
    {
        return $this->jobTitleService->show($id);
    }

    public function store(JobTitleStoreRequest $request): JsonResponse
    {
        $this->jobTitleService->save($request->validated());

        return response()->json(['message' => __('success_saved')]);
    }


    public function update(JobTitleUpdateRequest $request, int $id): JsonResponse
    {
        $this->jobTitleService->update($request->validated(), $id);

        return response()->json(['message' => __('success_updated')]);
    }

    public function destroy(int $id): JsonResponse
    {
        try {
            $this->jobTitleService->delete($id);

            return response()->json(['message' => __('success_deleted')]);
        } catch (\Exception $e) {
            return response()->json([], 422);
        }

    }
}
