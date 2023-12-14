<?php

namespace App\Traits;

trait RoutingLocation
{
    protected function routingByDistance($lat,$lon,$locations){

        $locations = array_map(function($location) use ($lat, $lon) {
            $location["distance"] = $this->haversineDistance($lat,$lon,$location["latitude"],$location["longitude"]);
            return $location;
        }, $locations->toArray());

        usort($locations, function($a, $b) {
            return $a["distance"] <=> $b["distance"];
        });

        return $locations;
    }


    protected function haversineDistance($lat1, $lon1, $lat2, $lon2)
    {
        $lat1 = deg2rad($lat1);
        $lon1 = deg2rad($lon1);
        $lat2 = deg2rad($lat2);
        $lon2 = deg2rad($lon2);

        $dlat = $lat2 - $lat1;
        $dlon = $lon2 - $lon1;

        $a = sin($dlat / 2) ** 2 + cos($lat1) * cos($lat2) * sin($dlon / 2) ** 2;
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        $R = 6371.0;

        $distance = $R * $c;

        return $distance;
    }
}
