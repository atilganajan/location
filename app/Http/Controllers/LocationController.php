<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateLocationRequest;
use App\Http\Requests\UpdateLocationRequest;
use Illuminate\Http\Request;
use App\Repositories\LocationRepository;
use Illuminate\Support\Facades\Log;

class LocationController extends Controller
{

    public function __construct(
        protected LocationRepository $locations,
    ) {}

   public function index(){
       return view("pages.home");
   }

   public function list(){
       try {
          return response()->json(["status"=>true,"locations"=>$this->locations->get()]);
       }catch (\Exception $err){
           Log::error("Listing locations Error:".$err->getMessage());
            return response()->json(["status"=>false,"errors"=>"Unexpected error"]);
       }
   }

   public function store(CreateLocationRequest $request){
       try {
           $this->locations->create($request->all());
           return response()->json(["status"=>true,"message"=>"Location created successfully."]);
       }catch (\Exception $err){
           Log::error("Create Location Error:".$err->getMessage());
           return response()->json(["status"=>false,"errors"=>"Unexpected error"],500);
       }

   }

   public function show($id){
       try {
           return response()->json(["status"=>true,"location"=>$this->locations->find($id)]);
       }catch (\Exception $err){
           Log::error("Show Location Error:".$err->getMessage());
           return response()->json(["status"=>false,"errors"=>"Unexpected error"],500);
       }
   }

    public function update(UpdateLocationRequest $request){
        try {
            $this->locations->update($request->all());
            return response()->json(["status"=>true,"message"=>"Location updated successfully."]);
        }catch (\Exception $err){
            Log::error("Update Location Error:".$err->getMessage());
            return response()->json(["status"=>false,"errors"=>"Unexpected error"],500);
        }
    }

    public function delete(Request $request){
        try {
            $this->locations->delete($request->id);
            return response()->json(["status"=>true,"message"=>"Location deleted successfully."]);
        }catch (\Exception $err){
            Log::error("Delete Location Error:".$err->getMessage());
            return response()->json(["status"=>false,"errors"=>"Unexpected error"],500);
        }
    }


}

