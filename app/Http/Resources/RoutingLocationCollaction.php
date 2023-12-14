<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Traits\RoutingLocation;

class RoutingLocationCollaction extends ResourceCollection
{
    use RoutingLocation;
    private $locations;

    public function __construct($data)
    {
        $this->locations = $this->routingByDistance($data["lat"],$data["lon"],$data["locations"]);
    }

    public function toArray(Request $request): array
    {
        return collect($this->locations)->map(function ($location) {
            return new LocationResource($location);
        })->all();
    }
}
