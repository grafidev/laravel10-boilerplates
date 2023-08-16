<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;

trait Activable
{
    public function scopeEnabled(Builder $builder)
    {
        return $builder->where($this->activationField(), '1');
    }

    public function scopeDisabled(Builder $builder)
    {
        return $builder->where($this->activationField(), '0');
    }

    public function activate()
    {
        return $this->update([$this->activationField() => true]);
    }

    public function deactivate()
    {
        return $this->update([$this->activationField() => false]);
    }

    public function activationField()
    {
        return 'active';
    }
}
