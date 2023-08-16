<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['name' => Role::SUPER_ADMIN, 'description' => 'Super administrateur'],
            ['name' => Role::ADMIN, 'description' => 'Administrateur'],
            ['name' => Role::USER, 'description' => 'Utilisateur'],
        ];

        foreach ($roles as $role) {
            Role::query()->updateOrCreate([
                'name' => $role['name'],
            ], [
                'name' => $role['name'],
                'description' => $role['description'],
            ]);
        }
    }
}
