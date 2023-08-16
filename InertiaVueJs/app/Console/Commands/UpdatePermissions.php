<?php

namespace App\Console\Commands;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class UpdatePermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permissions:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update permissions';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        Artisan::call('db:seed', [
            '--class' => 'PermissionSeeder',
        ]);

        $adminRole = Role::where('name', Role::ADMIN)->first();
        $adminRole->syncPermissions(Permission::all());

        $this->info('Permissions updated successfully :)');
    }
}
