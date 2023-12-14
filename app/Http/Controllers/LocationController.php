<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateLocationRequest;
use App\Http\Requests\UpdateLocationRequest;
use App\Repositories\LocationRepository;
use Illuminate\Http\Request;

class LocationController extends Controller
{

    public function __construct(
        protected LocationRepository $locations,
    ){}

    public function index()
    {
        return view("pages.home");
    }

    public function list()
    {
        return response()->json(["status" => true, "locations" => $this->locations->get()]);
    }

    public function store(CreateLocationRequest $request)
    {
        $this->locations->create($request->all());
        return response()->json(["status" => true, "message" => "Location created successfully."]);
    }

    public function show($id)
    {
        return response()->json(["status" => true, "location" => $this->locations->find($id)]);

    }

    public function update(UpdateLocationRequest $request)
    {
        $this->locations->update($request->all());
        return response()->json(["status" => true, "message" => "Location updated successfully."]);

    }

    public function delete(Request $request)
    {
        $this->locations->delete($request->id);
        return response()->json(["status" => true, "message" => "Location deleted successfully."]);

    }


}

