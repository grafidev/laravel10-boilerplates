<?php

namespace App\SearchAspects;

use App\Repositories\UserRepository;
use Illuminate\Support\Collection;
use Spatie\Searchable\SearchAspect;

class UserSearchAspect extends SearchAspect
{
    public function __construct(private UserRepository $userRepository)
    {
    }

    public function getResults(string $term): Collection
    {
        return $this->userRepository->query()->search(['search' => $term])->get();
    }

    public function getType(): string
    {
        return 'Comptes utilisateurs';
    }
}
