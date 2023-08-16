<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;

trait FilterByCompany
{
    public static function boot()
    {
        parent::boot();

        static::addGlobalScope(function (Builder $query) {
            return $query->where([
                'company_id' => current_company_id(),
                'country_id' => authUser()->country_id,
            ]);
        });
    }
}
