<?php

namespace App\Http\Controllers;

use App\Http\Requests\Department\DepartmentRequest;
use App\Models\User\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class DepartmentController extends Controller
{
    public function index(): Collection
    {
        return Department::all();
    }

    public function store(DepartmentRequest $request)
    {
        Department::create($request->validated());
    }

    public function update(DepartmentRequest $request, int $id)
    {
        Department::find($id)->update($request->validated());
    }

    public function destroy(int $id)
    {
        Department::find($id)->delete();

        return response()->json(['message' => __('success_deleted')]);
    }
}
