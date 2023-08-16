<?php

namespace App\Models\Traits;

use App\Models\History;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait Historiable
{
    public function histories(): MorphMany
    {
        return $this->morphMany(History::class, 'historiable');
    }
}
