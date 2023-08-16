<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;
use Kyslik\ColumnSortable\Sortable as kSortable;

trait Sortable
{
    use kSortable;

    public function parseSort(string $attribute): array
    {
        $sortOrder = 'ASC';
        if (strncmp($attribute, '-', 1) === 0) {
            $sortOrder = 'DESC';
            $attribute = substr($attribute, 1);
        }

        return [$attribute, $sortOrder];
    }

    public function scopeSortableUsing(Builder $query, ?string $sort)
    {
        if ($sort !== null) {
            [$sort, $direction] = $this->parseSort($sort);

            return $query->sortable([$sort => $direction]);
        }

        return $query;
    }
}
