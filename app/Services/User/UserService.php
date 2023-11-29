<?php

declare(strict_types=1);

namespace App\Services\User;

use App\Enums\SexType;
use App\Enums\StatusType;
use App\Models\User\Department;
use App\Models\User\JobTitle;
use App\Models\User\User;
use Illuminate\Support\Collection;
use Spatie\Permission\Models\Role;

class UserService
{
    public function getAll(): Collection
    {
        return User::all();
    }

    public function store(array $data): void
    {
        User::create($data);
    }

    public function update(array $data, int $id): void
    {
        User::find($id)->update($data);
    }

    public function delete(int $id): void
    {
        User::find($id)->delete();
    }

    public function getDataForEditForm(): Collection
    {
        return collect(
            [
                'genders' => SexType::getValues(),
                'roles' => Role::all()->toArray(),
                'departments' => Department::all()->toArray(),
                'job_titles' => JobTitle::all()->toArray(),
                'statuses' => StatusType::getValues(),
            ]
        );
    }
}
