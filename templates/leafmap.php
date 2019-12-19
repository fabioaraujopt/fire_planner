<style>
    div[data-key] {
        color: black;
    }
    
    .btn-primary{
        margin-right:2px;
    }

    .button_image{
        width:20px;
        height:20px;
    }
    
    .btn{
        margin:2px;
    }

</style>

<script>
<?php 
if(isset($_SESSION['lat']) && isset($_SESSION['lng']) && isset($_SESSION['zoom']) ){?>
    var session_lat = <?php echo $_SESSION['lat']; ?>;
    var session_lng = <?php echo $_SESSION['lng']; ?>;
    var session_zoom = <?php echo $_SESSION['zoom']; ?>;
<?php } else{?>
    var session_lat = 39.498318;
    var session_lng = -9.022042;
    var session_zoom = 11;
    
<?php } ?>
</script>


<!--Map Buttons-->
<div class="mb-2">
    <a href="#" class="btn btn-danger btn-circle float-left" id="trucks_toogle_button" style="background-color: orange;border-color: orange;">
        <i class="fa fa-truck"></i>
    </a>
    <a href="#" class="btn btn-warning btn-circle icon_drone float-left" id="drones_toogle_button" style="background-color: #dede00;border-color:#dede00;">
        <img class="button_image" src="icon/drone_white.svg">
    </a>
    <a href="#" class="btn btn-info btn-circle icon_sensor float-left" id="sensors_toogle_button">
        <img class="button_image" src="icon/sensor_white.svg">
    </a>
    <a href="#" class="btn btn-danger btn-circle icon_fire float-left" id="flame_toogle_button">
        <i class="fas fa-fire"></i>
    </a>

    <div class="dropdown">
        <button class="btn btn-secondary dropdown-toggle float-left" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-cog"></i>
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <div class="dropdown-item">Fire distance 
                <select class="float-right" id="threshold_value">
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                    <option value="200">200</option>
                    <option value="300">300</option>
                    <option value="400">400</option>
                    <option value="500">500</option>
                    <option value="700">700</option>
                </select>
                <select class="float-right" id="threshold_unit">
                    <option value="1">m</option>
                    <option value="1000">km</option>
                </select>
            </div>
            <div class="dropdown-item">Fire detection time
                <select class="float-right" id="threshold_value">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="15">15</option>
                    <option value="30">30</option>
                    <option value="45">45</option>
                    <option value="100">100</option>
                    <option value="200">200</option>
                    <option value="300">300</option>
                </select>
                <select class="float-right" id="threshold_unit">
                    <option value="1">m</option>
                    <option value="10">h</option>
                    <option value="100">d</option>
                </select>
            </div>
            <div class="dropdown-item">Geotiff Time
                <select class="float-right" id="threshold_value">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="15">15</option>
                    <option value="30">30</option>
                    <option value="45">45</option>
                    <option value="100">100</option>
                    <option value="200">200</option>
                    <option value="300">300</option>
                </select>
                <select class="float-right" id="threshold_unit">
                    <option value="1">m</option>
                    <option value="10">h</option>
                    <option value="100">d</option>
                </select>
            </div>
        </div>
    </div>
    
    <a href="#" class="btn btn-primary pull-right" id="rgb_button">
        <span class="text">RGB</span>
    </a>
    <a href="#" class="btn btn-primary pull-right" id="nvdi_button">
        <span class="text">NVDI</span>
    </a>
    <a href="#" class="btn btn-primary pull-right" id="savi_button">
        <span class="text">SAVI</span>
    </a>
</div>

<script>
    $('.dropdown-menu').on('click', function(e) {
        e.stopPropagation();
    });
</script>

<!--Map-->
<div id="map" style="width:100%;height: 68%;" ></div>
<p><a href="https://www.maptiler.com/copyright/" target="_blank">© MapTiler</a> <a href="https://www.openstreetmap.org/copyright" target="_blank">© OpenStreetMap contributors</a></p>


<!--Map scripts-->
<script src="js/map_default.js"></script>
<!--ROSLIB scripts-->
<script src="https://static.robotwebtools.org/roslibjs/current/roslib.min.js"></script>

<script>
    //TODO
    //* notifications (fire-> timer to db look for new detections and lost devices->try again/ignore)
    //* save map location in session

    class fireMarker{
        //data {longitude:123123}
        constructor(map_marker,map,data,index){
            this.marker= map_marker;
            this.map = map;
            this.data = data;
            this.device_categories_index=index;

            this.updateInfo();
        }

        toogle(){
            if (this.map.hasLayer(this.marker)) {
                this.map.removeLayer(this.marker)
            } else {
                this.map.addLayer(this.marker)
            }
        }

        updateInfo(){
            var info ="";

            if("latitude" in this.data && "longitude" in this.data) {
                info =info + '<div>GPS: ' + this.data['latitude'].toFixed(6) + ' ' + this.data['longitude'].toFixed(6);
            }
            if ("altitude" in this.data) {
                info = info + '<div>Altitude: ' + Math.round(this.data['altitude']) + '</div>';
            }
            if ("time" in this.data) {
                info = info + '<div>Report Time: ' + this.data['time'] + '</div>';
            }
            if("image" in this.data){
                info = info + '<div class="btn btn-primary btn-sm" onclick="showImage('+this.device_categories_index+')">' +
                    '<span class="text">Image</span>' +
                    '</div>';
            }
            this.marker.bindPopup(info);
        }

        showImage(){
            console.log("hey!");
            $("#detectionImageModal").modal('show');
            $("#detectedImage").attr('src',this.data.image);
        }
    }

    //known messages may be loaded from PHP DB
    var msgs =
        [
            {'key': 'currentImu', 'variables': ['orientation']},
            {'key': 'currentLocation', 'variables': ['altitude', 'longitude', 'latitude']},
            {'key': 'currentBattery', 'variables': ['percentage']},
            {'key': 'currentTemp', 'variables': ['temperature']}
        ];


    //icons defined for each device type
    icons= {'drone':drone,'sensor':sensor,'fire_truck':fire_truck,'flame':flame};
    var devices_categories = [];

    //device list PHP DB
    var devices=[
        <?php 
        $result = $conn->query("select * from devices");
        $array= $result->fetchAll();
        $len = count($array);
        $i=0;
        foreach($array as $device){?>
            {'name':'<?php echo $device['device_name']; ?>','ip': '<?php echo $device['device_ip']; ?>','type':'<?php echo $device['type']; ?>','rate':<?php echo $device['rate'];?>, 'image_ip':'<?php echo $device['device_image_ip']; ?>'} <?php if(!(($len - $i) == 1)){echo ',';} ?>
        <?php  } ?>
    ];
    
    //marker Class (everything related to the marker) 
    //device marker
    //this.state = 0 means that device is out
    class marker {
        constructor(lflt_marker, map, msgs, device, hasImage = false) {
            this.marker = lflt_marker;
            this.msg_types = msgs;
            this.time = device.rate;
            this.device = device;
            this.data = {};
            this.hasImage = hasImage;
            this.map = map;
            this.latest_update=this.getTime();
            this.state="";
            this.sent_alert=0;
            this.second_alert=0;
            

            this.run();
            this.toogle();
        }
        
        updateInfo() {
            var info = "";
            var milisecs_after_5_iterations= this.time*5;
            if(Object.entries(this.data).length === 0 
                && this.data.constructor === Object 
                && ((Math.abs(new Date(this.latest_update) - new Date(this.getTime())))>milisecs_after_5_iterations))
            {
                if(!this.sent_alert){
                    addAlert(1,this.device.name+' is not connected!');
                    this.sent_alert=1;
                }
                info = info + '<span style="font-weight: bold;">Device not connected</span>';
                this.state=0;
            }
            else if(Math.abs(new Date(this.latest_update) - new Date(this.getTime())>50000)){
                if(!this.second_alert){
                    addAlert(1,this.device.name+' is not connected!');
                    this.second_alert=1;
                }
                this.state=0;
            }else {
                this.state=1;
            }
                
            if("latitude" in this.data && "longitude" in this.data) {
                info =info + '<div>GPS: ' + this.data['latitude'].toFixed(6) + ' ' + this.data['longitude'].toFixed(6);
            }
            if ("altitude" in this.data) {
                info = info + '<div>Altitude: ' + Math.round(this.data['altitude']) + '</div>';
            }
            if ("temperature" in this.data) {
                info = info + '<div>Temperature: ' + this.data['temperature'] + '</div>';
            }
            if ("time" in this.data) {
                info = info + '<div>Report Time: ' + this.data['time'] + '</div>';
            }
            if(this.state && this.device.image_ip!=""){
                //ADD MODAL BUTTON
            }
            
            this.marker.bindPopup(info);
        }
        
        imageConnect() {
            //open modal
            var ros = new ROSLIB.Ros({
                url : 'ws://'+this.device.image_ip+':9090'
            });
            
            ros.on('connection', function() {
                
                //clean_modal
                //open_modal
                
                //REVIEW NAME
                var listener = new ROSLIB.Topic({
                        ros : ros,
                        name : '/'+this.device.name+'/ImgRaw',
                        messageType : 'sensor_msgs/CompressedImage'
                });

                listener.subscribe(this.imageReceiver());
                
            });
            
            
            
        }
        
        imageReceiver(frame){
            var src = `data:image/${frame.format};base64,${frame.data}`;
            //update modal with image
        }
    
        
        imageDisconnect(){
            listener.unsubscribe(this.imageReceiver());
        }
    
        
        updateLocation() {
            try {
                this.marker.setLatLng([this.data['latitude'], this.data['longitude']]).update();
            } catch (e) {

            }

        }

        getTime() {
            var today = new Date();
            var date = today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + today.getDate();
            var time = (today.getHours()<10?'0':'') + today.getHours() + ":" + (today.getMinutes()<10?'0':'') + today.getMinutes() + ":" + (today.getSeconds()<10?'0':'') + today.getSeconds();
            return date + ' ' + time;
        }

        toogle() {
            if (this.map.hasLayer(this.marker)) {
                this.map.removeLayer(this.marker)
            } else {
                this.map.addLayer(this.marker)
            }
        }

        run() {
            var self = this;
            window.setInterval(function () {
                self.device.device_state.callService(self.device.request_state, function (result) {
                    self.msg_types.forEach(function(element){
                        if(element.key in result.deviceState){
                            var request_result = result.deviceState[element.key];
                            element.variables.forEach(function(variable){
                                self.data[variable]= request_result[variable];
                            });
                        }
                    });
                    var time=self.getTime();
                    self.data['time'] = time; 
                    self.latest_update= time;
                });
                self.updateInfo();
                self.updateLocation();
            }, self.time);
        }
    }
    
    //websockets clients for devices READY
    var websockets=[];
    devices.forEach(function (element) {
        var websocket_exists = 0;
        websockets.forEach(function (websocket) {
            if (element.ip == websocket[0]) {
                websocket_exists = 1;
                element.socket= websocket[1];
            }
        });
        if (!websocket_exists) {
            var ros = new ROSLIB.Ros();
            ros.connect('ws:/'+element.ip+'/');
            websockets.push([element.ip, ros]);
            element.socket= ros;
            ros.on('error', function(error) {
                console.log('Error connecting to websocket server: ', error);
            });
        }
        
    });


    
    
    //[device_name,service_client]
    var service_clients = [];
    devices.forEach(function(element){
        element.device_state= new ROSLIB.Service({
            ros : element.socket,
            name : '/'+element.name+'/interoperability/state_srv',
            serviceType : 'focor_interoperability/FocorState'
        });
        
        element.request_state= new ROSLIB.ServiceRequest({
            robot_id : {
                data : 0
            }  });
        
        devices_categories.push([element['type'],new marker(
            L.marker([38.736946, -9.142685], {icon: icons[element['type']]}).addTo(map),
            map,
            msgs,
            element
        )]);
        
    });
    
    var detections=[];
    <?php
    foreach($conn->query("select * from detection_images LEFT JOIN detection_status on detection_images.status=detection_status.status_id") as $row){
        ?>
        var latitude=<?php echo $row['center_lat']; ?>;
        var longitude=<?php echo $row['center_lng']; ?>;
        var altitude=<?php echo $row['altitude']; ?>;
        var time='<?php echo $row['image_time']; ?>';
        var path='<?php echo $row['image_path']; ?>';
        detections.push([latitude,longitude]);
        index= devices_categories.length;
        devices_categories.push(['flame',
            new fireMarker(
                L.marker([latitude, longitude], {icon: icons['flame']}),
                map,
                {
                    'latitude':latitude,'longitude':longitude,'altitude':altitude,'time':time,
                    'image': 'detection_images/'+path
                },
                index
            )]);
    <?php } ?>

    //L.marker([38.746946, -9.142775], {icon: icons['sensor']}).addTo(map);
    //L.marker([38.716946, -9.142895], {icon: icons['flame']}).addTo(map);

    
    //handle for show geotiff images
    var rgb_images=[];
    var nvdi_images=[];
    var savi_images=[];
    <?php $js_array=['rgb_images','nvdi_images','savi_images']; ?>
    <?php $result = $conn->query("select * from ground_images");
    foreach($result->fetchAll() as $image){?>
    <?php echo $js_array[$image['image_type']];?>.push(L.imageOverlay(
        'geotiff_images/<?php echo $image['image_path'];?>', 
        [
            [<?php echo $image['top_left_lat'];?>,<?php echo $image['top_left_lng'];?>],
            [<?php echo $image['bottom_right_lat'];?>,<?php echo $image['bottom_right_lng'];?>]
        ]));
    <?php }?>
    
    //handler to save image
    $("#saveFrameButton").on('click', function(){
        $.ajax({
            type: "POST",
            url: "?",
            data: {'liveImageFrame': $("#liveFrame").attr('src')},
            success: function (data) {
                console.log(data);
            }
        });
    });
    
    
    //utils for style
    $(".reset").remove();
    $("a[title='Enter address']").remove();
    
    //map style adapt
    $(".geosearch.leaflet-bar.leaflet-control.leaflet-control-geosearch form").css('margin-bottom','0px');
    $(".geosearch.leaflet-bar.leaflet-control.leaflet-control-geosearch form").css('background','white');
    $(".geosearch.leaflet-bar.leaflet-control.leaflet-control-geosearch form").css('opacity','0.7');

    
    
    
    

    /*
     //var regex = "\/(vigil|rics_matrice_210_rtk)\/(sensor|filter)\/(gps|imu|bms)\/.*"
    //get all relevant topics/msgs
    //ATENÇÃO PHP PARA DEFINIR OS DEVICE NAMES
    var relevant_topics = [];
    var relevant_msgs = [];
    var relevant_sockets =[];
    var device_listeners =[];
    websockets.forEach(function (socket,i) {
        socket[1].on('connection', function () {
            socket[1].getTopics(function (topics) {
                //retirar todos os topicos relevantes
                topics['topics'].forEach(function (element, i) {
                        if (element.match(regex)) {
                            relevant_topics.push(element);
                            relevant_msgs.push(topics['types'][i]);
                            relevant_sockets.push(socket);
                        }
                    }
                );
                //remover sensores quando há filtros
                var relevant_topics_loop = relevant_topics;
                relevant_topics_loop.forEach(function (element) {
                    var match = element.match("\/filter\/(.*)\/");
                    if (match) {
                        relevant_topics_loop.forEach(function (element, i) {
                            if (element.match("\/sensor\/(" + match[1] + ")\/")) {
                                relevant_topics.splice(i, 1);
                                relevant_msgs.splice(i, 1);
                            }
                        });
                    }
                });

                devices.forEach(function(device){
                    listener=[];
                    relevant_topics.forEach(function(topic,i){
                        var match=topic.match('\/'+device['name']+'\/.*\/(.*)\/.*');
                        if(match){
                            listener.push([match[1],new ROSLIB.Topic({
                                ros : relevant_sockets[i][1],
                                name : topic,
                                messageType : relevant_msgs[i]
                            })]);
                        }
                    });
                    device_listeners.push(listener);
                    devices_categories.push([device['type'],new marker(
                        L.marker([38.736946, -9.142685], {icon: icons[device['type']]}).addTo(map),
                        map,
                        listener,
                        msg_types,
                        device['name'],
                        device['rate']
                    )]);
                    
                });
                
            });
        });
    });
    */
  
</script>

<script src = "js/fire_filter.js"></script>

<script src="js/markers_button_events.js"></script> 
<script src ="js/threshold_listener.js"></script>
