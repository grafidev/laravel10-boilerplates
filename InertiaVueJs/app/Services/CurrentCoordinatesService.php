<?php

namespace App\Services;

use Exception;
use GuzzleHttp\Client;
use Spatie\Geocoder\Geocoder;

class CurrentCoordinatesService
{
    public static function getValue(array $defaultCoordinates = [-14.452362, 14.497401]): array
    {
        try {
            $country = get_current_country();
            $client = new Client();
            $geocoder = new Geocoder($client);

            $geocodeResult = $geocoder->getCoordinatesForAddress($country?->code ?? 'SN');

            $latitude = $geocodeResult['lat'] ?? $defaultCoordinates[0];
            $longitude = $geocodeResult['lng'] ?? $defaultCoordinates[1];

            return [$latitude, $longitude];
        } catch (Exception $e) {
            return $defaultCoordinates;
        }
    }
}
