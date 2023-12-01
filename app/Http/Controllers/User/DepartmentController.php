<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Department\DepartmentStoreRequest;
use App\Http\Requests\User\Department\DepartmentUpdateRequest;
use App\Models\User\Department;
use App\Services\User\DepartmentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;

class DepartmentController extends Controller
{
    protected DepartmentService $departmentService;

    public function __construct(DepartmentService $departmentService)
    {
        $this->departmentService = $departmentService;
    }

    public function index(): Collection
    {
        return $this->departmentService->getAll();
    }

    public function show(int $id): Collection
    {
        return $this->departmentService->show($id);
    }

    public function store(DepartmentStoreRequest $request): JsonResponse
    {
        $this->departmentService->save($request->validated());

        return response()->json(['message' => __('success_saved')]);
    }

    public function update(DepartmentUpdateRequest $request, int $id): JsonResponse
    {
        $this->departmentService->update($request->validated(), $id);

        return response()->json(['message' => __('success_updated')]);
    }

    public function destroy(int $id): JsonResponse
    {
        $this->departmentService->delete($id);

        return response()->json(['message' => __('success_deleted')]);
    }
}
