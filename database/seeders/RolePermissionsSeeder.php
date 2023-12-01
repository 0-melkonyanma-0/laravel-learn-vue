<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolePermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        collect(config('roles')['permissions'][0])->each(function ($keys, $resource) {
            collect($keys)->each(function ($permission) use($resource) {
                Permission::findOrCreate($permission . ' ' . $resource);
            });
        });

        collect(config('roles')['roles'])->each(function ($key, $role) {
            $role = Role::findOrCreate($role);
            collect($key)->each(function ($permissions, $resource) use ($role) {
                collect($permissions)->each(function ($permission) use ($role, $resource) {
                    $role->givePermissionTo(Permission::findOrCreate($permission . " " . $resource));
                });
            });
        });
    }
}
