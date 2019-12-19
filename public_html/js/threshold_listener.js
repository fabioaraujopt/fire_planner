$("#threshold_value").on('change',function(){
    var unit=$("#threshold_unit").val();
    detection_threshold= this.value * unit;
    
    console.log(detection_threshold);
});

$("#threshold_unit").on('change',function(){
    var value = $("#threshold_value").val();
    detection_threshold = value * this.value;

    console.log(detection_threshold);
});

