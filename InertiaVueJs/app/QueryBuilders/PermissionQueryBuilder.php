<?php

namespace App\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;

class PermissionQueryBuilder extends Builder
{
    public function search($filters)
    {
        foreach ($filters as $key => $value) {
            if ($value === null) {
                continue;
            }

            switch ($key) {
                case 'search':
                    $this
                        ->where('name', 'ilike', '%'.$value.'%')
                        ->orWhere('description', 'ilike', '%'.$value.'%');
                    break;
            }
        }

        return $this;
    }
}
