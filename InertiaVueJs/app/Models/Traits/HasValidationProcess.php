<?php

namespace App\Models\Traits;

trait HasValidationProcess
{
    public static function getId(string $name): ?int
    {
        return self::query()->firstWhere('name', $name)?->getKey();
    }
}
