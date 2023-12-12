const map = new ol.Map({
    layers: [
        new ol.layer.Tile({
            source: new ol.source.OSM(),
        }),
    ],
    target: 'map',
    view: new ol.View({
        center: ol.proj.fromLonLat([29.0204988, 41.0788495]),
        zoom: 15,
        constrainRotation: false,
        extent: ol.proj.get("EPSG:3857").getExtent(),

    }),
});

const markers = new ol.layer.Vector({
    source: new ol.source.Vector(),
});

const overlayElement = document.createElement('div');
overlayElement.innerHTML = `<i class="fa-solid fa-location-dot"  style="color:#000000 ; font-size: 26px"></i>`;

$("#createLocationColorInput").on("input", function () {
    const newColor = $(this).val();

    overlayElement.innerHTML = `<i class="fa-solid fa-location-dot" style="color: ${newColor}; font-size: 26px"></i>`;

    map.removeOverlay(overlay);

    const newOverlay = new ol.Overlay({
        position: overlay.getPosition(),
        element: overlayElement,
        positioning: overlay.getPositioning(),
        offset: overlay.getOffset(),
        stopEvent: false,
    });

    map.addOverlay(newOverlay);
});



const overlay = new ol.Overlay({
    position: ol.proj.fromLonLat([29.0204988, 41.0788495]),
    element: overlayElement,
    positioning: 'bottom-center',
    offset: [0, 4],
    stopEvent: false
});

map.addOverlay(overlay);


map.on('click', function (evt) {
    const coords = ol.proj.toLonLat(evt.coordinate);
    const lat = coords[1];
    const lon = coords[0];

    $.ajax({
        url: `https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}`,
        method: 'GET'
    }).done(function (data) {
        const locationName = data.display_name;

        if(locationName === undefined){

            AlertMessages.showError(["No such location was found."], 3000);
            return false;
        }

        new ol.Feature(new ol.geom.Point(ol.proj.fromLonLat([lon, lat])));
        markers.getSource().clear();

        $("#createLocationLatitudeInput").val(lat);
        $("#createLocationLongitudeNameInput").val(lon);
        $("#createLocationNameInput").val(locationName);

        const overlay = new ol.Overlay({
            position: ol.proj.fromLonLat([lon, lat]),
            element: overlayElement,
            positioning: 'bottom-center',
            offset: [0, 4],
            stopEvent: false
        });

        map.addOverlay(overlay);

    })
        .fail(function (error) {
            AlertMessages.showError(["Error fetching location name"], 3000);
        });
});


function findLocation() {
    const locationName = $("#createLocationNameInput").val();

    $.ajax({
        url: 'https://nominatim.openstreetmap.org/search',
        method: 'GET',
        data: {
            q: locationName,
            format: 'json',
        }
    }).done(function (data) {
        if (data.length > 0) {
            const lat = data[0].lat;
            const lon = data[0].lon;
            $("#createLocationLatitudeInput").val(lat);
            $("#createLocationLongitudeNameInput").val(lon);

            const newCenter = ol.proj.fromLonLat([lon, lat]);
            map.getView().setCenter(newCenter);

            markers.getSource().clear();

            const overlay = new ol.Overlay({
                position: ol.proj.fromLonLat([lon, lat]),
                element: overlayElement,
                positioning: 'bottom-center',
                offset: [0, 4],
                stopEvent: false
            });

            map.addOverlay(overlay);

        } else {
            AlertMessages.showError(["No results found for the given address"], 3000);
        }
    }).fail(function (error) {
        AlertMessages.showError(["Error fetching location coordinates"], 3000);
    });
}

function openCreateLocationModal() {

    $("#locationCreateModal").modal("show");

}

function saveLocation(){

    const formData = $("#createLocationForm").serialize();
    const routeName = $('#createLocationForm').attr('action');

    $.ajax({
        type: "POST",
        url: routeName,
        data: formData,

    }).done(function (data){
        console.log(data)
    }).fail(function (err){
        console.log(err)
    });

}


