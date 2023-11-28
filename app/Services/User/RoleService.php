<?php

declare(strict_types=1);

namespace App\Services\User;

use Illuminate\Support\Collection;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleService
{
    public function getAll(): Collection
    {
        return Role::whereNotIn('name', ['admin'])->get();
    }

    public function getPermissions(): Collection
    {
        return Permission::all();
    }

    public function store(array $data): void
    {
        Role::create(['name' => $data['title']])
            ->syncPermissions(
                Permission::whereIn(
                    'name',
                    $data['permissions']
                )
                    ->pluck('name')
            );
    }

    public function update(array $data, int $id): void
    {
        $role = Role::update(['name' => $data['title']]);

        $role->syncPermissions(Permission::whereIn('name', $data['permissions'])->get());
    }

    public function delete(int $id): void
    {
        Role::find($id)->delete();
    }
}
