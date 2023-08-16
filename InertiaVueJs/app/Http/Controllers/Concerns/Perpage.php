<?php

namespace App\Http\Controllers\Concerns;

trait Perpage
{
    public function getPerpage($model)
    {
        $sessionKey = 'PERPAGE_KEY_'.$model;

        session()->put($sessionKey, request('perpage', session($sessionKey, 15)));

        return session($sessionKey);
    }
}
