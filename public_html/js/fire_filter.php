<script>
//detections variable is initialized on top

//distance in meters minimum to  accept a fire alert
var detection_threshold= 100;

//distance in meters from coordinates
function distance_meters(lat_1,lng_1,lat_2,lng_2){
    var x = GeographicLib.Geodesic.WGS84, r;
    r = x.Inverse(lat_1, lng_1, lat_2, lng_2);
    return r.s12.toFixed(3);
}


<?php $result = $conn->query("select * from fire_detection_devices");
foreach($result->fetchAll() as $device){?>

new ROSLIB.Ros({url : 'ws://<?php echo $device['fire_detection_ip']; ?>:9090'}).on('connection', function() {
    console.log("connected to <?php echo $device['fire_detection_ip']; ?>");
    
    var fireAlertServer = new ROSLIB.Service({
        ros : ros,
        name : 'vigil/interoperability/fireAlertSrv',
        serviceType : 'focor_interoperability/FocorFireAlert'
    });

    fireAlertServer.advertise(function(request, response) {
        
        timeStamp = request.fireAlert.header.stamp.secs;
        latitude = request.fireAlert.fireLocation.latitude;
        longitude = request.fireAlert.fireLocation.longitude;
        altitude = request.fireAlert.fireLocation.altitude;
        image=request.fireAlert.fireImage.data;
        
        
        //calcular distancia da deteção atual, relativamente a todas as deteções
        distances=[];
        detections.forEach(function(detection){
            if(detection[0] != null && detection[1] != null){
                distances.push(distance_meters(detection[0], detection[1], latitude, longitude));
            }
        });
        console.log(Math.min(...distances));
        if(Math.min(...distances) > detection_threshold){
            var index=devices_categories.length;
            //add valid detection to detections array
            detections.push([latitude, longitude]);
            
            //add marker to markers list
             devices_categories.push(['flame',
                new fireMarker(
                    L.marker([latitude, longitude], {icon: icons['flame']}),
                    map,
                    {
                        'latitude':latitude,'longitude':longitude,'altitude':altitude,'time':timeStamp,
                        'image': 'data:image/jpeg;base64,'+image
                    },
                    index
                )]);
             
             //send detection to database
            $.ajax({
                type: "POST",
                url: "?",
                data: {'new_detection':{'lat':latitude,'lng': longitude, 'altitude': altitude, 'time':timeStamp,'image':image}},
                success: function (data) {
                    console.log(data);
                }
            });


        }
        
        response['fire'] = true; // aqui metes a resposta do utilizador
        return true;
    });
    
});

function showImage(index){
    devices_categories[index][1].showImage();
}

<?php } ?>
</script>