<?php

namespace App\Models\Traits;

use Exception;
use Illuminate\Database\Eloquent\Model;

trait HasPinCode
{
    protected function generateUniquePinCode(string $model, int $length = 6)
    {
        $pinCode = '';
        $unique = false;
        $model = app($model);

        if (! $model instanceof Model) {
            throw new Exception("$model is a model class");
        }

        do {
            $pinCode = str_pad(rand(0, 999999), $length, '0', STR_PAD_LEFT); // Generate a six-digit PIN code
            $unique = ! $model->query()->where('pin_code', $pinCode)->exists();
        } while (! $unique);

        return $pinCode;
    }
}
