<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateLocationRequest;
use Illuminate\Http\Request;

class LocationController extends Controller
{
   public function index(){
       return view("pages.home");
   }

   public function store(CreateLocationRequest $request){


   }

}

