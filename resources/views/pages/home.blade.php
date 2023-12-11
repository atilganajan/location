@extends('layouts.master')

@section('title', 'Location App')

@section('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/ol@v8.2.0/ol.css">
    <link rel="stylesheet" href="{{ asset('assets/css/home/home.css') }}" >
@endsection

@section('content')
    <div class="top-action row w-100 m-0 justify-content-center ">
        <div class="card col-lg-4">
            <div class="text-center" onclick="openCreateLocationModal()">
                <p><i class="fa-solid fa-map-pin"></i> Create Location</p>
            </div>
        </div>
    </div>


    <!--Location create modal Start-->
    <div class="modal fade show" id="locationCreateModal" data-bs-backdrop='static'>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Create Location</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="createLocationForm">
                        <div id="map" style="width: 100%; height: 400px;"></div>
                        <div>
                            <label for="createLocationNameInput">Name:</label>
                            <div class="row" >
                                <div class="col-10" ><input class="form-control shadow-sm" id="createLocationNameInput" type="text"  name="name"></div>
                                <div class="col-2 ps-0" ><button class="btn btn-primary w-100" type="button" onclick="findLocation()">Find</button></div>
                            </div>
                        </div>
                        <div>
                            <label for="createLocationNameInput">Latitude:</label>
                            <input class="form-control shadow-sm" id="createLocationLatitudeInput" type="text" readonly value="0" name="latitude">
                        </div>
                        <div>
                            <label for="createLocationNameInput">Longitude:</label>
                            <input class="form-control shadow-sm" id="createLocationLongitudeNameInput" type="text" readonly value="0"  name="longitude">

                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success" onclick="saveLocation()">Save</button>
                </div>
            </div>
        </div>
    </div>
    <!--Location create modal End-->

@endsection


@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/ol@v8.2.0/dist/ol.js"></script>
    <script src="{{asset('assets/js/home/home.js')}}" ></script>
    <script>

    </script>
@endsection
