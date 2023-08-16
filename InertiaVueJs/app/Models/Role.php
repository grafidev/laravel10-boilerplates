<?php

namespace App\Models;

use App\Models\Traits\Sortable;
use App\QueryBuilders\RoleQueryBuilder;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class Role extends \Spatie\Permission\Models\Role implements Searchable
{
    use Sortable;

    public const SUPER_ADMIN = 'SUPER_ADMIN';

    public const ADMIN = 'ADMIN';

    public const USER = 'USER';

    public const CONFIGURED_PERMISSIONS = [
        ['name' => 'list_role', 'description' => 'Lister des roles'],
        ['name' => 'create_role', 'description' => 'Créer un role'],
        ['name' => 'show_role', 'description' => 'Voir un role'],
        ['name' => 'edit_role', 'description' => 'Modifier un role'],
        ['name' => 'delete_role', 'description' => 'Supprimer un role'],
        ['name' => 'restore_role', 'description' => 'Restaurer un role'],
        ['name' => 'forceDelete_role', 'description' => 'Supprimer définitivement un role'],
    ];

    public static function getId(string $name)
    {
        return self::where('name', $name)->first()?->id;
    }

    public function getSearchResult(): SearchResult
    {
        return new SearchResult(
            $this,
            $this->description,
            route('dashboard.roles.edit', $this->id)
        );
    }

    public function newEloquentBuilder($query)
    {
        return new RoleQueryBuilder($query);
    }
}
