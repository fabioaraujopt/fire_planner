v
<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

include __DIR__ . '/../app/database.php';
include __DIR__ . '/../app/auth.php';


$conn = database::mySqlPDO();
!empty($_SESSION["userId"]) ? $authUser = true : $authUser = false;

if($authUser){
    foreach ($conn->query("select * from users where user_id=" . $_SESSION['userId']) as $row) {
        $login_name = $row['name'];
        $role = $row['role'];
    }
}


//DEFINIR RANGE DE AVISO

if ($conn != false) {
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['login'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];
            $member = Auth::getMember($conn, $email, $password);
            $member ? $_SESSION["userId"] = true : $wrongCredentials = true;
        }
        if (isset($_POST['logout'])) {
            session_unset();
            session_destroy();
        }
        if (isset($_POST['register_user']) && $role==1){
            //falta tratamento (não haverem nomes iguais, roles dentro dos parametros)
           $prepared=$conn->prepare('insert into users (name,email, password, role) values (:name,:email,:password,:role)');
           $prepared->execute([':email' => $_POST['email'],':name'=>$_POST['name'], ':password' => $_POST['password'],':role'=>$_POST['role']]);
        }
        if (isset($_POST['delete_user']) && $role==1){
            //falta tratamento (não haverem nomes iguais, roles dentro dos parametros)
            $prepared=$conn->prepare("delete from users where email = :email");
            $prepared->execute([':email'=>$_POST['delete_user']]);
        }
        if(isset($_POST['confirm_fire'])){
            //DEFINIR RANGE DE AVISO
            $string = explode(" ", $_POST['img_fire_path']);
            $last = end($string);

            $prepared=$conn->prepare('update detection_images SET  status= :status');
            $prepared->execute([':status'=>$_POST['confirm_fire']]);
            
            //img_fire_path
        }
        if(isset($_POST['map_position'])){
            $_SESSION['lat']=$_POST['map_position']['lat'];
            $_SESSION['lng']=$_POST['map_position']['lng'];
            $_SESSION['zoom']=$_POST['map_position']['zoom'];
            
            $ajax_call=1;
        }
        if(isset($_POST['liveImageFrame'])){
            print_r($_POST['liveImageFrame']);
            //save image in DB
            $ajax_call=1;
        }
        if(isset($_POST['new_detection'])){
            //save image with random id
            $file_name=md5(uniqid(rand(), true)).'.jpg';
            file_put_contents('detection_images/'.$file_name, base64_decode($_POST['new_detection']['image']));
            
            //convert timestamp to readable time
            $time=date('Y-m-d H:i:s', $_POST['new_detection']['time']);
            
            //get other params
            $lat = $_POST['new_detection']['lat'];
            $lng = $_POST['new_detection']['lng'];
            $altitude = $_POST['new_detection']['altitude'];
            
            $prepared=$conn->prepare(
                'insert into detection_images(image_path,center_lat,center_lng,status,image_time) values (:path,:lat,:lng,1,:time)');
            $prepared->execute(['lat' => $lat,'lng'=>$lng, 'time' =>$time,'path'=>$file_name]);
            
            $ajax_call=1;
        }
    }
    
    if(!isset($ajax_call)) {
        include "../templates/header.html";
        if (!$authUser) {
            include('../templates/login.php');
        } else {
            include('../templates/dashboard.php');
        }
    }
    
}else{
    echo "DB Out";
}
?>
