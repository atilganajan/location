<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

trait LocationValidationTrait
{
    protected function checkTolerance(Request $request, $latitudeKey, $longitudeKey, $nameKey)
    {
        try {
            $response = Http::get("https://nominatim.openstreetmap.org/search", [
                'q' => $request->input($nameKey),
                'format' => 'json',
            ]);

            $data = json_decode($response->body());

            if (count($data) > 0) {
                $apiLat = $data[0]->lat;
                $apiLon = $data[0]->lon;

                $userLat = $request->input($latitudeKey);
                $userLon = $request->input($longitudeKey);

                $errorMargin = 0.01; // TODO Tolerance

                $latDiff = abs($apiLat - $userLat);
                $lonDiff = abs($apiLon - $userLon);

                if ($latDiff > $errorMargin || $lonDiff > $errorMargin) {
                    return 'Location tolerance has been exceeded, please update the location';
                }
            } else {
                return 'Location not found.';
            }
        } catch (\Exception $err) {
            Log::error("Check location tolarance  Error:".$err->getMessage());
            return 'Unexpected error.';
        }

        return null;
    }
}
