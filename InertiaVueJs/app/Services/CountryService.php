<?php

namespace App\Services;

use Illuminate\Support\Arr;
use Monarobase\CountryList\CountryListFacade;

class CountryService
{
    public static function make()
    {
        $items = [];

        $jsonData = CountryListFacade::getList('fr', 'json');

        $data = json_decode($jsonData, true);

        foreach ($data as $k => $v) {
            $items[] = ['label' => $v, 'value' => $k];
        }

        return $items;
    }

    public static function getName(string $countryCode): ?string
    {
        $countries = array_filter(CountryService::make(), fn ($country) => $country['value'] == $countryCode);

        if (count($countries) > 0) {
            $country = Arr::first($countries);

            return $country['label'];
        }

        return null;
    }
}
