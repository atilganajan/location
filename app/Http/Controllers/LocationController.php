<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateLocationRequest;
use App\Http\Requests\RoutingLocationRequest;
use App\Http\Requests\UpdateLocationRequest;
use App\Http\Resources\LocationCollaction;
use App\Http\Resources\LocationResource;
use App\Http\Resources\RoutingLocationCollaction;
use App\Repositories\LocationRepository;
use App\Services\RoutingService;
use Illuminate\Http\Request;

class LocationController extends ApiController
{
    protected LocationRepository $locations;

    public function __construct(LocationRepository $locations)
    {
        $this->locations = $locations;
    }

    public function index()
    {
        return view("pages.home");
    }

    public function list()
    {
        $locations = $this->locations->get();
        return $this->successResponse(new LocationCollaction($locations));
    }

    public function store(CreateLocationRequest $request)
    {

        $this->locations->create($request->validated());
        return $this->successResponse(null, "Location created successfully", 201);
    }

    public function show($id)
    {
        $location = $this->locations->find($id);
        return $this->successResponse(new LocationResource($location));
    }

    public function update(UpdateLocationRequest $request)
    {
        $this->locations->update($request->validated());
        return $this->successResponse(null, "Location updated successfully");
    }

    public function delete(Request $request)
    {
        $this->locations->delete($request->id);
        return $this->successResponse(null, "Location deleted successfully");
    }

    public function routing(RoutingLocationRequest $request)
    {
        $routingService = new RoutingService();
        $locations = $routingService->processRouting($this->locations->get(), $request->latitude, $request->longitude);
        return $this->successResponse(new RoutingLocationCollaction($locations));
    }
}
