<?php

namespace App\Models\Traits;

trait CanBeCancelled
{
    public function markAsCancelled(): bool
    {
        return $this->forceFill(['cancelled' => true])->save();
    }
}
