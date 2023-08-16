<?php

namespace App\SearchAspects;

use App\Repositories\AdminRoleRepository;
use Illuminate\Support\Collection;
use Spatie\Searchable\SearchAspect;

class RoleSearchAspect extends SearchAspect
{
    public function __construct(private AdminRoleRepository $adminRoleRepository)
    {
    }

    public function getType(): string
    {
        return 'Roles';
    }

    public function getResults(string $term): Collection
    {
        return $this->adminRoleRepository->query()->search(['search' => $term])->get();
    }
}
