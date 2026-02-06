<?php

namespace App\Traits;

use Illuminate\Support\Facades\Log;

trait GeoNamesTrait
{
    private function getCountryName($countryCode)
    {
        $username = 'coral220422';
        $url = "https://secure.geonames.org/countryInfoJSON?country={$countryCode}&username={$username}";

        try {
            $geoResponse = file_get_contents($url);
            if ($geoResponse === false) {
                throw new \Exception("No se pudo obtener la respuesta de GeoNames.");
            }
            $geoData = json_decode($geoResponse, true);
            if (!empty($geoData['geonames'][0]['countryName'])) {
                return $geoData['geonames'][0]['countryName'];
            }
        } catch (\Exception $e) {
            Log::error("Error obteniendo el país: " . $e->getMessage());
        }

        return 'Desconocido';
    }

    private function getGeonameById($geonameId)
    {
        $username = 'coral220422';
        $url = "https://secure.geonames.org/getJSON?geonameId={$geonameId}&username={$username}";

        try {
            $geoResponse = file_get_contents($url);
            if ($geoResponse === false) {
                throw new \Exception("No se pudo obtener la respuesta de GeoNames.");
            }
            $geoData = json_decode($geoResponse, true);
            if (!empty($geoData['name'])) {
                return $geoData;
            }
        } catch (\Exception $e) {
            Log::error("Error obteniendo la ubicación: " . $e->getMessage());
        }

        return null;
    }
}
