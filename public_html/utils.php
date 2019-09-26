

<script src="js/dropzone.js"></script>

<form action="/file-upload" class="dropzone">
    <div class="fallback">
        <input name="file" type="file" multiple />
    </div>
</form>

<script>
    var myDropzone = new Dropzone(".dropzone", { url: "/file/post"});
</script>


<?php
function DMS2Decimal($degrees = 0, $minutes = 0, $seconds = 0, $direction = 'n') {
    //converts DMS coordinates to decimal
    //returns false on bad inputs, decimal on success

    //direction must be n, s, e or w, case-insensitive
    $d = strtolower($direction);
    $ok = array('n', 's', 'e', 'w');

    //degrees must be integer between 0 and 180
    if(!is_numeric($degrees) || $degrees < 0 || $degrees > 180) {
        $decimal = false;
    }
    //minutes must be integer or float between 0 and 59
    elseif(!is_numeric($minutes) || $minutes < 0 || $minutes > 59) {
        $decimal = false;
    }
    //seconds must be integer or float between 0 and 59
    elseif(!is_numeric($seconds) || $seconds < 0 || $seconds > 59) {
        $decimal = false;
    }
    elseif(!in_array($d, $ok)) {
        $decimal = false;
    }
    else {
        //inputs clean, calculate
        $decimal = $degrees + ($minutes / 60) + ($seconds / 3600);

        //reverse for south or west coordinates; north is assumed
        if($d == 's' || $d == 'w') {
            $decimal *= -1;
        }
    }

    return $decimal;
}


echo system ('ls');