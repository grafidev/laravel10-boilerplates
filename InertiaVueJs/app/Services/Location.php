<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Fluent;

class Location
{
    public static function fromIp($ip): Fluent
    {
        $response = Http::acceptJson()->get("http://ip-api.com/json/{$ip}");

        return new Fluent($response->json());
    }
}
