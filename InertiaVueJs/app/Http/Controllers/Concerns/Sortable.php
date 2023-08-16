<?php

namespace App\Http\Controllers\Concerns;

trait Sortable
{
    public function parseSort(string $attribute): array
    {
        $sortOrder = 'ASC';
        if (strncmp($attribute, '-', 1) === 0) {
            $sortOrder = 'DESC';
            $attribute = substr($attribute, 1);
        }

        return [$attribute, $sortOrder];
    }
}
