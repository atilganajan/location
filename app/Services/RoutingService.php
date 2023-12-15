<?php

namespace App\Services;

use App\Traits\RoutingLocation;

class RoutingService
{
    use RoutingLocation;

    public function processRouting($locations, $latitude, $longitude)
    {
        return $this->routingByDistance($latitude,$longitude,$locations);
    }
}
