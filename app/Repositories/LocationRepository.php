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
        return Location::create([
            "name"=> $data["name"],
            "latitude" => $data["latitude"],
            "longitude" => $data["longitude"],
            "marker_color" => $data["marker_color"],
        ]);
    }

    public function update(array $data)
    {
        return Location::find($data["location_id"])->update([
            "name"=> $data["name"],
            "latitude" => $data["latitude"],
            "longitude" => $data["longitude"],
            "marker_color" => $data["marker_color"],
        ]);
    }

    public function delete($id)
    {
        return Location::find($id)->delete();
    }




}
