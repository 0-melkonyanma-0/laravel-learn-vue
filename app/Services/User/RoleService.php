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
        $roles = collect([]);

        Role::with(['permissions'])->whereNotIn('name', ['admin'])
            ->get()
            ->each(function ($item) use ($roles) {
                $roles[] = [
                    'id' => $item['id'],
                    'name' => $item['name'],
                    'permissions' => $item['permissions']->pluck('id')
                ];
            });

        return $roles;
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
                    'id',
                    $data['permissions']
                )
                    ->pluck('id')
            );
    }

    public function update(array $data, int $id): void
    {
        $role = Role::find($id)->syncPermissions(Permission::whereIn('id', $data['permissions'])->get());
        $role->update(['name' => $data['title']]);
    }

    public function delete(int $id): void
    {
        Role::find($id)->delete();
    }
}
