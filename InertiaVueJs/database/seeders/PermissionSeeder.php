<?php

namespace Database\Seeders;

use App\Models\Dashboard;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            ...User::CONFIGURED_PERMISSIONS,
            ...Role::CONFIGURED_PERMISSIONS,
            ...Permission::CONFIGURED_PERMISSIONS,
            ...Dashboard::CONFIGURED_PERMISSIONS,
        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(['name' => $permission['name']], $permission);
        }
    }
}
