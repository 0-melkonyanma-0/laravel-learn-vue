<?php

declare(strict_types=1);

namespace App\Services\User;

use App\Enums\SexType;
use App\Enums\StatusType;
use App\Models\User\Department;
use App\Models\User\JobTitle;
use App\Models\User\User;
use Illuminate\Support\Collection;
use Spatie\Activitylog\Models\Activity;
use Spatie\Permission\Models\Role;

class UserService
{
    public function getAll(): Collection
    {
        return User::all()->reject(function (User $value, int $key) {
            return in_array('admin', $value->roles()->pluck('name')->toArray(), true);
        });
    }

    public function show(int $id): Collection
    {
        return collect([
            'user' => User::whereId($id)->with(['roles'])->get(),
            'activity_log' => Activity::where('subject_id', '=', $id)->orderBy('created_at', 'desc')->get()
        ]);
    }

    public function store(array $data): void
    {
        User::create($data);
    }

    public function update(array $data, int $id): void
    {
        $user = User::find($id);

        if (!isset($data['password'])) {
            $user->update([
                'name' => $data['name'],
                'email' => $data['email'],
                'sex' => $data['sex'],
                'status' => $data['status'],
                'job_title_id' => isset($data['job_title_id']) ? $data['job_title_id'] : null,
                'department_id' => isset($data['department_id']) ? $data['department_id'] : null,
            ]);
        } else {
            $user->update($data);
        }

        $user->syncRoles($data['role']);
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
                'roles' => Role::whereNotIn('name', ['admin'])->get()->toArray(),
                'departments' => Department::all()->toArray(),
                'job_titles' => JobTitle::all()->toArray(),
                'statuses' => StatusType::getValues(),
            ]
        );
    }
}
