//alerts[type,message]
var alerts=[];

//add alerts to alert box
function addAlert(type,message){
    if(type==1){
        var icon=
            '<div class="mr-3">' +
            '<div class="icon-circle bg-warning">' +
            '<i class="fas fa-times"></i>' +
            '</div>' +
            '</div>';
        var buttons= '<button class="btn btn-primary btn-sm float-right" id="ignore_'+alerts.length+'" onclick="removeAlert(this.id);">Ignore</button>';
    }
    if(type==2){
        var icon=
            '<div class="mr-3">' +
            '<div class="icon-circle bg-danger">' +
            '<i class="fas fa-exclamation-triangle"></i>' +
            '</div>' +
            '</div>';

        var buttons =
            '<button class="btn btn-primary btn-sm float-right alert_btn">Ignore</button>'+
            '<button class="btn btn-primary btn-sm float-right alert_btn">Ignore</button>'+
            '<button class="btn btn-primary btn-sm float-right alert_btn">Ignore</button>';
    }


    var notification= '' +
        '<div class="notification_element dropdown-item" id="notification_">' +
        '<div class="d-flex align-items-center">'+icon+
        '<div>' +
        '<div class="small text-gray-500 time_update">'+Date.now()+'</div>' +
        '<div>'+message+'</div></div></div>' +
        buttons
    '</div>';

    $("#ignore_"+alerts.length).on('click',function(){
        console.log("hey");
    });
    
    $("#alerts_div").prepend(notification);
    alerts.push([type,message,moment()]);
    
    

}

//interval to update alerts timing
setInterval (function(){
    var alert= alerts;
    $(".time_update").each(function (i) {
        element = $(this);
        element.html(moment(alert[i][2]).fromNow());
    });
    if(alert.length>0){
        $("#alert_number").show();
        $("#alert_number").html(alert.length+'+');
    }else{
        $("#alert_number").hide();
    }
}, 2000 );

function removeAlert(id){
    $("#"+id).parent().fadeOut(300, function() { $(this).remove(); });
    //remove element from alerts data
}

