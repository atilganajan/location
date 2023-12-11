const map = new ol.Map({
    layers: [
        new ol.layer.Tile({
            source: new ol.source.OSM(),
        }),
    ],
    target: 'map',
    view: new ol.View({
        center: [0, 0],
        zoom: 2,
    }),
});

const markers = new ol.layer.Vector({
    source: new ol.source.Vector(),
});


const overlayElement = document.createElement('div');
overlayElement.innerHTML = '<i class="fa-solid fa-location-dot"  style="color: #a62121; font-size: 22px"></i>';

const overlay = new ol.Overlay({
    position: ol.proj.fromLonLat([0, 0]),
    element: overlayElement,
    positioning: 'bottom-center',
    offset:  [0, 4],
    stopEvent: false
});

map.addOverlay(overlay);



map.on('click', function(evt){
    const coords = ol.proj.toLonLat(evt.coordinate);
    const lat = coords[1];
    const lon = coords[0];

    fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}`)
        .then(response => response.json())
        .then(data => {

            var locationName = data.display_name;
            console.log("Location Name: " + locationName);
        })
        .catch(error => {
            console.error('Error fetching location name:', error);
        });



    const marker = new ol.Feature(new ol.geom.Point(ol.proj.fromLonLat([lon, lat])));
    markers.getSource().clear();


    const overlay = new ol.Overlay({
        position: ol.proj.fromLonLat([lon, lat]),
        element: overlayElement,
        positioning: 'bottom-center',
        offset:  [0, 4],
        stopEvent: false
    });

    map.addOverlay(overlay);

});


/*
function updateMapCenter() {
    var latitude = parseFloat(latitudeInput.value) || 0;
    var longitude = parseFloat(longitudeInput.value) || 0;
    var newCenter = ol.proj.fromLonLat([longitude, latitude]);

    map.getView().setCenter(newCenter);
}
*/

function addLocation() {
    var locationName = document.getElementById('createLocationNameInput').value;
    var latitude = parseFloat(document.getElementById('createLocationLatitudeInput').value) || 0;
    var longitude = parseFloat(document.getElementById('createLocationLongitudeNameInput').value) || 0;

    var newCenter = ol.proj.fromLonLat([longitude, latitude]);

    map.getView().setCenter(newCenter);

}
function openCreateLocationModal() {
    $("#locationCreateModal").modal("show")
}


/*
Coloris({
    el: '.changeColorInput'
});*/
