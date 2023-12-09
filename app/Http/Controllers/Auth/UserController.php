<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserStoreRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Services\User\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Get authenticated user.
     */
    public function current(Request $request): JsonResponse
    {
        return response()->json([$request->user(), Auth::user()->allPermissions]);
    }

    public function index(): Collection
    {
        return $this->userService->getAll();
    }

    public function show(int $id): Collection
    {
        return $this->userService->show($id);
    }

    public function store(UserStoreRequest $request): JsonResponse
    {
        $this->userService->store($request->validated());

        return response()->json(['message' => __('success_saved')]);
    }

    public function update(UserUpdateRequest $request, int $id): JsonResponse
    {
        $this->userService->update($request->validated(), $id);

        return response()->json(['message' => __('success_updated')]);
    }

    public function destroy(int $id): JsonResponse
    {
        try {
            $this->userService->delete($id);

            return response()->json(['message' => __('success_deleted')]);
        } catch (\Exception $e){
            return response()->json([], 422);
        }
    }

    public function getDataForEditForm(): COllection
    {
        return $this->userService->getDataForEditForm();
    }
}
