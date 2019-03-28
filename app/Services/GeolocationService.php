<?php

namespace App\Services;

class GeolocationService
{
    /**
     * @param string $address
     * @param $apiKey
     * @return array
     */
    public function getGeolocation(string $address, $apiKey)
    {
        $MY_API_KEY = $apiKey ?? config('gmaps.api_key');

        $address    = urlencode($address);
        $geocode    = file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?address={$address}&key={$MY_API_KEY}");
        $output     = json_decode($geocode);

        try {
            return [
                'lat'   => $output->results[0]->geometry->location->lat,
                'long'  => $output->results[0]->geometry->location->lng
            ];
        }
        catch (\ErrorException $e) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'address_col' => ['Неправильная буква колонки с адресом']
            ]);
        }
    }
}