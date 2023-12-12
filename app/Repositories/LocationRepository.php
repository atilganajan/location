<?php

namespace App\Repositories;

use App\Models\Location;

class LocationRepository
{
    public function find($id)
    {
        return Location::find($id);
    }

    public function get()
    {
        return Location::orderBy("created_at","desc")->get();
    }

    public function create(array $data)
    {
        return Location::create($data);
    }

    public function update($id, array $data)
    {
        $location = Location::find($id);
        if ($location) {
            $location->update($data);
            return $location;
        }

        return null;
    }


}
