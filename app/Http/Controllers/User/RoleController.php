<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Role\RoleStoreRequest;
use App\Http\Requests\User\Role\RoleUpdateRequest;
use App\Services\User\RoleService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;

class RoleController extends Controller
{
    protected RoleService $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    public function index(): Collection
    {
        return $this->roleService->getAll();
    }

    public function getPermissions(): Collection
    {
        return $this->roleService->getPermissions();
    }

    public function store(RoleStoreRequest $request): JsonResponse
    {
        $this->roleService->store($request->validated());

        return response()->json(['message' => __('success_saved')]);
    }

    public function update(RoleUpdateRequest $request, int $id): JsonResponse
    {
        $this->roleService->update($request->validated(), $id);

        return response()->json(['message' => __('success_updated')]);
    }

    public function destroy(int $id): JsonResponse
    {
        $this->roleService->delete($id);

        return response()->json(['message' => __('success_deleted')]);
    }
}
