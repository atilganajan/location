<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateLocationRequest;
use Illuminate\Http\Request;
use App\Repositories\LocationRepository;

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
            return response()->json(["status"=>false,"message"=>"Unexpected error"]);
       }
   }

   public function store(CreateLocationRequest $request){

       try {
           $this->locations->create($request->all());
           return response()->json(["status"=>true,"message"=>"Location created successfully."]);
       }catch (\Exception $err){
           return response()->json(["status"=>false,"message"=>"Unexpected error"],500);
       }

   }

}

