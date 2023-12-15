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
        $fillableFields = ['name', 'latitude', 'longitude', 'marker_color'];
        $fillableData = array_only($data, $fillableFields);

        return Location::create($fillableData);
    }

    public function update(array $data)
    {
        $fillableFields = ['name', 'latitude', 'longitude', 'marker_color'];
        $fillableData = array_only($data, $fillableFields);

        return Location::find($data["location_id"])->update($fillableData);
    }

    public function delete($id)
    {
        return Location::find($id)->delete();
    }




}
