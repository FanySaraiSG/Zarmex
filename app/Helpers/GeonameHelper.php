<?php

namespace App\Helpers;

class GeonameHelper
{
    public static function getCountryName($countryCode)
    {
        $username = 'coral220422'; // Usuario de GeoNames
        $geoResponse = @file_get_contents("https://secure.geonames.org/countryInfoJSON?country={$countryCode}&username={$username}");

        if ($geoResponse) {
            $geoData = json_decode($geoResponse, true);
            if (!empty($geoData['geonames']) && isset($geoData['geonames'][0]['countryName'])) {
                return $geoData['geonames'][0]['countryName'];
            }
        }

        // Si GeoNames falla, usar REST Countries
        $restResponse = @file_get_contents("https://restcountries.com/v3.1/alpha/{$countryCode}");
        if ($restResponse) {
            $restData = json_decode($restResponse, true);
            return $restData[0]['name']['common'] ?? 'Desconocido';
        }

        return 'Desconocido';
    }
}
