<?php

namespace App\QueryBuilders;

use App\Models\Role;
use Illuminate\Database\Eloquent\Builder;

class UserQueryBuilder extends Builder
{
    public function superAdmin()
    {
        return $this->whereHas('roles', fn (Builder $query) => $query->whereIn('name', [Role::SUPER_ADMIN]));
    }

    public function admin()
    {
        return $this->whereHas('roles', fn (Builder $query) => $query->whereIn('name', [Role::ADMIN]));
    }

    public function user()
    {
        return $this->whereHas('roles', fn (Builder $query) => $query->whereIn('name', [Role::USER]));
    }

    public function search(array $filters)
    {
        foreach ($filters as $key => $value) {
            if ($value === null) {
                continue;
            }

            switch ($key) {
                case 'search':
                    $this
                        ->where(function ($q) use ($value) {
                            $q->where('name', 'ilike', '%'.$value.'%')
                                ->orWhere('firstname', 'ilike', '%'.$value.'%')
                                ->orWhere('lastname', 'ilike', '%'.$value.'%')
                                ->orWhere('email', 'ilike', '%'.$value.'%')
                                ->orWhere('phone_number', 'ilike', '%'.$value.'%')
                                ->orWhere('address', 'ilike', '%'.$value.'%');
                        });
                    break;
            }
        }

        return $this;
    }
}
