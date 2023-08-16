<?php

namespace App\Models;

use App\QueryBuilders\PermissionQueryBuilder;

class Permission extends \Spatie\Permission\Models\Permission
{
    public const CONFIGURED_PERMISSIONS = [
        ['name' => 'list_permission', 'description' => 'Lister des permissions'],
        ['name' => 'create_permission', 'description' => 'Créer une permission'],
        ['name' => 'show_permission', 'description' => 'Voir une permission'],
        ['name' => 'edit_permission', 'description' => 'Modifier une permission'],
        ['name' => 'delete_permission', 'description' => 'Supprimer une permission'],
        ['name' => 'restore_permission', 'description' => 'Restaurer une permission'],
        ['name' => 'forceDelete_permission', 'description' => 'Supprimer définitivement une permission'],
    ];

    public function newEloquentBuilder($query)
    {
        return new PermissionQueryBuilder($query);
    }
}
