const map = new ol.Map({
    layers: [new ol.layer.Tile({source: new ol.source.OSM()})],
    target: 'map',
    view: new ol.View({
        center: ol.proj.fromLonLat([29.0204988, 41.0788495]),
        zoom: 10,
        constrainRotation: false,
        extent: ol.proj.get('EPSG:3857').getExtent(),
    }),
});


const markers = new ol.layer.Vector({
    source: new ol.source.Vector(),
});

const overlayElement = document.createElement('div');
overlayElement.innerHTML = `<i class="fa-solid fa-location-dot"  style="color:#000000 ; font-size: 26px"></i>`;

$("#locationColor").on("input", function () {
    const newColor = $(this).val();
    overlayElement.querySelector('.fa-location-dot').style.color = newColor;

    overlay.setElement(overlayElement);
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

        if (locationName === undefined) {
            AlertMessages.showError(["No such location was found."], 2500);
            return false;
        }

        $("#locationName").val(locationName);

        findLocation(false)

    }).fail(function (error) {
        AlertMessages.showError(["Error fetching location name"], 2500);
    });
});


function findLocation(isCenter) {
    const locationName = $("#locationName").val();

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
            $("#locationLatitude").val(lat);
            $("#locationLongitude").val(lon);

            if (isCenter) {
                const newCenter = ol.proj.fromLonLat([lon, lat]);
                map.getView().setCenter(newCenter);
            }

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
            AlertMessages.showError(["No results found for the given address"], 2500);
        }
    }).fail(function (error) {
        AlertMessages.showError(["Error fetching location coordinates"], 2500);
    });
}


function saveLocation() {

    const formData = $("#locationForm").serialize();
    const routeName = $("#locationForm").attr('action');
    const method = $("#locationForm").data("method");

    $.ajax({
        type: method,
        url: routeName,
        data: formData,

    }).done(function (data) {
        $("#locationModal").modal("hide");
        AlertMessages.showSuccess(data.message, 2500);
        setTimeout(function () {
            window.location.reload();
        }, 2500)
    }).fail(function (err) {
        AlertMessages.showError(err.responseJSON.errors ?? err.responseJSON.message , 2500)
    });

}

function deleteLocation(id, routeName) {

    AlertConfirmModals.confirmModal("Are you sure?", "You won't be able to revert this!", "warning")
        .then((isConfirmed) => {
            if (isConfirmed) {
                $.ajax({
                    type: 'DELETE',
                    url: routeName,
                    data: {
                        id: id,
                    },
                }).done(function (data) {
                    AlertMessages.showSuccess(data.message, 2500);
                    setTimeout(function () {
                        window.location.reload();
                    }, 2500);
                }).fail(function (err) {
                    AlertMessages.showError(err.responseJSON.errors ?? err.responseJSON.message , 2500)
                });
            }
        });
}


function openCreateModal() {
    resetMap();
    $("#locationModal").modal("show");
}


function openUpdateModal(locationId, routeName) {
    resetMap();
    $.ajax({
        type: "GET",
        url: routeName,
    }).done(function (data) {
        const location = data.location;
        $("#locationName").val(location.name);
        $("#locationLatitude").val(location.latitude);
        $("#locationLongitude").val(location.longitude);
        $("#locationColor").val(location.marker_color).trigger("input");
        $("#modalTitle").html("Update Location <small style='font-size: 13px'>(You can mark the location on the map or locate it with find by typing the location name.)</small>");
        $("#location_id").val(locationId);

        $("#findLocationBtn").trigger("click");

        $("#locationForm").attr("action", $("#locationForm").data("update-url"));
        $("#locationForm").data("method", "PUT");

        $("#locationModal").modal("show");

    }).fail(function (err) {
        AlertMessages.showError(err.responseJSON.errors ?? err.responseJSON.message , 2500)
    });

}

function openShowModal(routeName) {
    resetMap();

    $.ajax({
        type: "GET",
        url: routeName,
    }).done(function (data) {
        const location = data.location;
        $("#locationName").val(location.name);
        $("#locationLatitude").val(location.latitude);
        $("#locationLongitude").val(location.longitude);
        $("#locationColor").val(location.marker_color).trigger("input");
        $("#modalTitle").html("Show Location");

        $("#findLocationBtn").trigger("click");

        $("#saveLocationBtn").hide();
        $("#findLocationBtn").hide();
        $("#locationName").attr("disabled", true);
        $("#locationColor").attr("disabled", true);
        $("#findParentDiv").removeClass("col-10");
        $("#findParentDiv").addClass("col-12");

        $("#map").css("pointer-events","none");

        $("#locationModal").modal("show");

    }).fail(function (err) {
        AlertMessages.showError(err.responseJSON.errors ?? err.responseJSON.message , 2500)
    });

}

function resetMap() {
    $("#map").css("pointer-events","auto");
    $("#locationName").val("");
    $("#locationLatitude").val("");
    $("#locationLongitude").val("");
    $("#locationColor").val("").trigger("input");
    $("#modalTitle").html("Create Location <small style='font-size: 13px'>(You can mark the location on the map or locate it with find by typing the location name.)</small>");
    $("#location_id").val("");

    $("#saveLocationBtn").show();
    $("#findLocationBtn").show();
    $("#locationName").attr("disabled", false);
    $("#locationColor").attr("disabled", false);
    $("#findParentDiv").removeClass("col-12");
    $("#findParentDiv").addClass("col-10");


    $("#locationForm").attr("action", $("#locationForm").data("create-url"));
    $("#locationForm").data("method", "POST");

    const newCenter = ol.proj.fromLonLat([29.0204988, 41.0788495]);
    map.getView().setCenter(newCenter);


    markers.getSource().clear();

    const overlay = new ol.Overlay({
        position: ol.proj.fromLonLat([29.0204988, 41.0788495]),
        element: overlayElement,
        positioning: 'bottom-center',
        offset: [0, 4],
        stopEvent: false
    });

    map.addOverlay(overlay);

}


function getRoutingBtn(){

    const formData = $("#routingForm").serialize();
    const routeName = $("#routingForm").attr('action');

    $.ajax({
        type: "POST",
        url: routeName,
        data: formData,

    }).done(function (data) {

        let html ="";

        data.locations.forEach((location)=>{
            let content = `
             <tr>
                <td>${location.name}</td>
                <td>${location.latitude}</td>
                <td>${location.longitude}</td>
                <td>${location.marker_color}</td>
            </tr>
            `;
            html +=content;
        })

        $("#routingTableBody").html(html);

    }).fail(function (err) {
        AlertMessages.showError(err.responseJSON.errors ?? err.responseJSON.message , 2500)
    });

}








