<?php

namespace App\Repositories;

use App\Models\Permission;

class PermissionRepository extends BaseRepository
{
    public function model(): string
    {
        return Permission::class;
    }

    public function getFieldsSearchable(): array
    {
        return [];
    }
}
