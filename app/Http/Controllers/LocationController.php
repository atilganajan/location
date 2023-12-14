<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateLocationRequest;
use App\Http\Requests\RoutingLocationRequest;
use App\Http\Requests\UpdateLocationRequest;
use App\Http\Resources\LocationCollaction;
use App\Http\Resources\LocationResource;
use App\Http\Resources\RoutingLocationCollaction;
use App\Repositories\LocationRepository;
use Illuminate\Http\Request;

class LocationController extends Controller
{

    public function __construct(
        protected LocationRepository $locations,
    )
    {}

    public function index()
    {
        return view("pages.home");
    }

    public function list()
    {
        return response()->json(["status" => true, "locations" => new LocationCollaction($this->locations->get())]);
    }

    public function store(CreateLocationRequest $request)
    {
        $this->locations->create($request->validated());
        return response()->json(["status" => true, "message" => "Location created successfully."], 201);
    }

    public function show($id)
    {
        return response()->json(["status" => true, "location" => new LocationResource($this->locations->find($id))]);

    }

    public function update(UpdateLocationRequest $request)
    {
        $this->locations->update($request->validated());
        return response()->json(["status" => true, "message" => "Location updated successfully."]);
    }

    public function delete(Request $request)
    {
        $this->locations->delete($request->id);
        return response()->json(["status" => true, "message" => "Location deleted successfully."]);

    }

    public function routing(RoutingLocationRequest $request)
    {
        $data = [
            "locations" => $this->locations->get(),
            "lat" => $request->latitude,
            "lon" => $request->longitude,
        ];

        return response()->json(["status" => true, "locations" => new RoutingLocationCollaction($data)]);
    }


}

