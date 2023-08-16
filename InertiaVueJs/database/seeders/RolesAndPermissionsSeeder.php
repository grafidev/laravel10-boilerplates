<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $superAdminRole = Role::where('name', Role::SUPER_ADMIN)->first();
        $adminRole = Role::where('name', Role::ADMIN)->first();
        $userRole = Role::where('name', Role::USER)->first();

        $superAdminRole->syncPermissions(Permission::all());
        $adminRole->syncPermissions(Permission::all());
        $userRole->syncPermissions(Permission::all());

        $superAdminUser = User::firstWhere('email', 'superadmin@mail.com');
        $adminUser = User::firstWhere('email', 'admin@mail.com');
        $userUser = User::firstWhere('email', 'user@mail.com');

        $superAdminUser->assignRole($superAdminRole);
        $adminUser->assignRole($adminRole);
        $userUser->assignRole($userRole);
    }
}
