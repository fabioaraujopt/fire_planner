
const provider = new window.GeoSearch.OpenStreetMapProvider();

const searchControl = new window.GeoSearch.GeoSearchControl({
    provider: provider,
    autoComplete: true,             // optional: true|false  - default true
    autoCompleteDelay: 250,
});

var map = L.map('map').setView([session_lat, session_lng], session_zoom);

map.addControl(searchControl);

L.tileLayer('https://api.maptiler.com/maps/hybrid/{z}/{x}/{y}.jpg?key=jiujn1VoKMBZvyOFPHq3',{
    tileSize: 512,
    zoomOffset: -1,
    minZoom: 1,
    attribution: '<a href="https://www.maptiler.com/copyright/" target="_blank">© MapTiler</a> <a href="https://www.openstreetmap.org/copyright" target="_blank">© OpenStreetMap contributors</a>',
    crossOrigin: true
}).addTo(map);



map.on('moveend', function(e) {
   
    $.ajax({
        type: "POST",
        url: "?",
        data: {'map_position':{'zoom':map._zoom,'lat':map._lastCenter.lat,'lng': map._lastCenter.lng}},
        success: function (data) {
            console.log(data);
        }
    });
    
    
});





var drone = L.icon({
    iconUrl: 'icon/drone.svg',
    iconSize: [25, 25], // size of the icon
});

var sensor = L.icon({
    iconUrl: 'icon/sensor.svg',
    iconSize: [20, 20], // size of the icon
});

var fire_truck=L.divIcon({
    html: '<i class="fa fa-truck fa-2x" style="color: orange"></i>',
    iconSize: [20, 20],
    className: 'myDivIcon'
});

var flame = L.divIcon({
    html: '<i class="fas fa-fire fa-2x" style="color:red"></i>',
    iconSize: [20, 20],
    className: 'myDivIcon'
});


