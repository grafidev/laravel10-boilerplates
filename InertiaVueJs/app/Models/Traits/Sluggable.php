<?php

namespace App\Models\Traits;

use Illuminate\Support\Str;

trait Sluggable
{
    public static function bootSluggable(): void
    {
        parent::creating(function ($model) {
            $model->slug = Str::slug($model->{self::fieldToSlugify()}, self::slugSeparator());
        });
    }

    public static function fieldToSlugify(): string
    {
        return 'name';
    }

    private static function slugSeparator(): string
    {
        return '_';
    }
}
