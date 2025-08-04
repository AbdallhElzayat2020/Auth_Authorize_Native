<?php

namespace Database\Seeders;

use App\Enums\PermissionsEnum;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = collect(PermissionsEnum::values())->map(function ($permissions) {
            return ['name' => $permissions];
        })->toArray();

        Permission::upsert($permissions, ['name']);

        $OwnerRole = Role::firstOrCreate(['role' => 'Owner']);
        $OwnerRole->permissions()->sync(Permission::pluck('id'));

    }
}

