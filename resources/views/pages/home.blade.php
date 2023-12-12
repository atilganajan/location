@extends('layouts.master')

@section('title', 'Location App')

@section('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/ol@v8.2.0/ol.css">
    <link rel="stylesheet" href="{{ asset('assets/css/home/home.css') }}">

@endsection

@section('content')
    <div class="top-action row w-100 m-0 justify-content-center ">
        <div class="card col-lg-4">
            <div class="text-center" onclick="openCreateLocationModal()">
                <p><i class="fa-solid fa-map-pin"></i> Create Location</p>
            </div>
        </div>
    </div>


    <div class="p-5">
        <table class="table table-striped table-class student-table" id="locationTable">
            <thead>
            <tr>
                <th>Name</th>
                <th>Latitude</th>
                <th>Longitude</th>
                <th>Marker Color</th>
                <th>Action</th>
            </tr>
            </thead>
            <thead>
            <tr>
                <th><input type="text" class="form-control shadow-sm filterInput " placeholder="Search name..."></th>
                <th><input type="text" class="form-control shadow-sm filterInput " placeholder="Search latitude..."></th>
                <th><input type="text" class="form-control shadow-sm filterInput " placeholder="Search longitude..."></th>
                <th><input type="text" class="form-control shadow-sm filterInput " placeholder="Search marker color..."></th>
                <th></th>
            </tr>
            </thead>

            <tbody>

            </tbody>
        </table>
    </div>


    <!--Location modal Start-->
    <div class="modal fade show modal-xl" id="locationModal" data-bs-backdrop='static'>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Create Location</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="locationForm" action="{{route("location.store")}}">
                        @csrf
                        <div id="map" style="width: 100%; height: 400px;"></div>
                        <div>
                            <label for="locationName">Name:</label>
                            <div class="row">
                                <div class="col-10">
                                    <input class="form-control shadow-sm" id="locationName"
                                                           placeholder="Example: Güvercin Sokağı, Levent Mahallesi, Beşiktaş, Istanbul, Marmara Region, 34330, Turkey"
                                                           type="text" name="name"></div>
                                <div class="col-2 ps-0">
                                    <button class="btn btn-primary w-100" type="button" onclick="findLocation(true)">
                                        Find
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="mt-1">
                            <label for="locationLatitude">Latitude:</label>
                            <input class="form-control shadow-sm" id="locationLatitude" type="text" readonly
                                   placeholder="Example: 41.0788495" name="latitude">
                        </div>
                        <div class="mt-1">
                            <label for="locationLongitude">Longitude:</label>
                            <input class="form-control shadow-sm" id="locationLongitude" type="text"
                                   readonly placeholder="Example: 29.0204988" name="longitude">
                        </div>
                        <div class="mt-1">
                            <label for="locationColor">Marker Color(hexadecimal):</label>
                            <input class="form-control shadow-sm locationColor"
                                   placeholder="Example: #000000" id="locationColor" type="text"
                                   name="marker_color">
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
    <!--Location modal End-->


@endsection


@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/ol@v8.2.0/dist/ol.js"></script>
    <script src="{{asset('assets/js/home/home.js')}}"></script>
    <script>
        $(document).ready(function() {
            $("body").tooltip({ selector: '[data-toggle=tooltip]' });
        });
        const locationTable = $('#locationTable').DataTable({
            paging: true,
            searching: true,
            ordering: true,
            info: true,
            responsive: true
        });

        $('.filterInput').on('keyup', function () {
            locationTable.columns($(this).parent().index()).search(this.value).draw();
        });

        $.ajax({
            type: 'GET',
            url: "{{route("location.list")}}",
        }).done(function (data) {
            $('#locationTable').DataTable().clear();

            data.locations.forEach(function (location) {
                const trimmedName = location.name.length > 50 ? location.name.substring(0, 50) + '...' : location.name;

                const fullText = location.name;

                $('#locationTable').DataTable().row.add([
                    `<span data-toggle="tooltip"  title="${fullText}">${trimmedName}</span>`,
                    location.latitude,
                    location.longitude,
                    location.marker_color,
                    `
                <button class="btn btn-sm bg-info text-white me-2" onclick="openShowModal(${location.id})"><i class="fa-solid fa-map"></i></button>
                <button class="btn btn-sm bg-primary text-white me-2" onclick="OpenUpdateModal(${location.id})"><i class="fa-solid fa-square-pen"></i></button>
                <button class="btn btn-sm bg-danger text-white" onclick="deleteLocation(${location.id})"><i class="fa-solid fa-trash"></i></button>`
                ]).draw();
            });

        }).fail(function (err) {
            console.log(err);
        });


    </script>
@endsection
