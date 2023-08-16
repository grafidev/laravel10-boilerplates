<?php

namespace App\QueryBuilders;

use App\Models\Role;
use App\Models\Traits\ForCompany;
use Illuminate\Database\Eloquent\Builder;

class RoleQueryBuilder extends Builder
{
    use ForCompany;

    public function validators()
    {
        return $this->whereIn('name', [Role::DIRECTEUR_COMMERCIAL, Role::DIRECTEUR_FINANCIER]);
    }

    public function admin()
    {
        return $this->whereNotIn('name', [
            Role::SUPER_ADMIN,
            Role::ADMIN,
            Role::CLIENT,
            Role::GERANT_STATION,
            Role::POMPISTE,
            Role::PORTEUR_CARTE,
        ]);
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
                        ->where(function (Builder $q) use ($value) {
                            $q->where('name', 'ilike', '%'.$value.'%')->orWhere('description', 'ilike', '%'.$value.'%');
                        });
                    break;
            }
        }

        return $this;
    }

    public function landlord()
    {
        return $this->whereNull('country_id')->whereNull('company_id');
    }

    public function forAdmin()
    {
        return $this->whereIn('name', [Role::SUPER_ADMIN, Role::ADMIN]);
    }
}
