@extends('layouts.master')

@section('title', 'Location App')

@section('styles')
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
                        <div>
                            <label for="createLocationNameInput">Name:</label>
                            <input class="form-control shadow-sm" id="createLocationNameInput" type="text" maxlength="100" name="name">
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
    <script src="{{asset('assets/js/home/home.js')}}" ></script>
@endsection
