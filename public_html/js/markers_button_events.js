

//listener for buttons 
var trucks_on = 0;
$("#trucks_toogle_button").on('click',function (e) {
    devices_categories.forEach(function (element) {
        if(element[0]=='fire_truck'){
            element[1].toogle();
        }
    });
    if(!trucks_on){
        $(this).css('box-shadow','0 0 0 0.2rem rgba(235,101,88,.5)');

        trucks_on=1;
    }else{
        $(this).css('box-shadow','none');
        trucks_on=0;
    }
});
var sensors_on = 0;
$("#sensors_toogle_button").on('click',function (e) {
    devices_categories.forEach(function (element) {
        if(element[0]=='sensor'){
            element[1].toogle();
        }
    });
    if(!sensors_on){
        $(this).css('box-shadow','0 0 0 0.2rem rgba(84,196,212,.5)');
        sensors_on=1;
    }else{
        $(this).css('box-shadow','none');
        sensors_on=0;
    }
});
var drones_on = 0;
$("#drones_toogle_button").on('click',function (e) {
    devices_categories.forEach(function (element) {
        if(element[0]=='drone'){
            element[1].toogle();
        }
    });
    if(!drones_on){
        $(this).css('box-shadow','0 0 0 0.2rem rgba(191, 191, 1, 0.5)');

        drones_on=1;
    }else{
        $(this).css('box-shadow','none');
        drones_on=0;
    }
});
var flames_on = 0;
$("#flame_toogle_button").on('click',function (e) {
    devices_categories.forEach(function (element) {
        if(element[0]=='flame'){
            element[1].toogle();
        }
    });
    if(!flames_on){
        $(this).css('box-shadow','0 0 0 0.2rem rgba(235, 101, 88, 0.5)');
        flames_on=1;
    }else{
        $(this).css('box-shadow','none');
        flames_on=0;
    }
});


var savi_on=0;
$("#savi_button").on('click',function (e) {
    toogleGroundImages(savi_images,'auto');toogleGroundImages(savi_images,'auto');
    if(!savi_on){
        $(this).css('box-shadow','0 0 0 0.2rem rgba(105, 136, 228, 0.5)');
        $("#rgb_button").css('box-shadow','none');
        $("#nvdi_button").css('box-shadow','none');
        savi_on=1;
        nvdi_on=0;
        rgb_on=0;

        toogleGroundImages(rgb_images,'off');
        
        toogleGroundImages(nvdi_images,'off');
    }else{
        $(this).css('box-shadow','none');
        savi_on=0;
    }
});

var nvdi_on=0;
$("#nvdi_button").on('click',function (e) {
    toogleGroundImages(nvdi_images,'auto');
    if(!nvdi_on){
        $(this).css('box-shadow','0 0 0 0.2rem rgba(105, 136, 228, 0.5)');
        $("#rgb_button").css('box-shadow','none');
        $("#savi_button").css('box-shadow','none');
        nvdi_on=1;
        savi_on=0;
        rgb_on=0;

        toogleGroundImages(rgb_images,'off');
        toogleGroundImages(savi_images,'off');
        
    }else{
        $(this).css('box-shadow','none');
        nvdi_on=0;
        
    }
});

var rgb_on=0;
$("#rgb_button").on('click',function (e) {
    toogleGroundImages(rgb_images,'auto');
    if(!rgb_on){
        $(this).css('box-shadow','0 0 0 0.2rem rgba(105, 136, 228, 0.5)');
        $("#savi_button").css('box-shadow','none');
        $("#nvdi_button").css('box-shadow','none');
        rgb_on=1;
        savi_on=0;
        nvdi_on=0;
        
        toogleGroundImages(savi_images,'off');
        toogleGroundImages(nvdi_images,'off');
    }else{
        $(this).css('box-shadow','none');
        rgb_on=0;
    }
});


function toogleGroundImages(array,type){
    array.forEach(function(element){
        if(type=='auto') {
            if (map.hasLayer(element)) {
                map.removeLayer(element);
            } else {
                element.addTo(map);
            }
        }else if (type=='off') {
            map.removeLayer(element);
        }
        else {
            element.addTo(map);
        }
    });
    
};


 