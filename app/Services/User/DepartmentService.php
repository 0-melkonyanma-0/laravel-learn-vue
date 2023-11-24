<?php

declare(strict_types=1);

namespace App\Services\User;

use App\Models\User\Department;
use Illuminate\Support\Collection;

class DepartmentService
{
    public function getAll(): Collection
    {
        return Department::all();
    }

    public function update(array $data, int $id): void
    {
        Department::find($id)->update($data);
    }

    public function save(array $data): void
    {
        Department::create($data);
    }

    public function delete(int $id): void
    {
        Department::find($id)->delete();
    }
}
