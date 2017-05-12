<?php
require_once 'DB_Functions.php';
$db = new DB_Functions();
if (isset($_POST['longitude'] ) && isset($_POST['latitude'])) {
	 $long=$_POST['longitude'];
	 $lat=$_POST['latitude'];
	 $user_id=$_POST['user_id'];
	 $result = $db->findlocation($long,$lat,$user_id);
	 if ($result != false) {
	 echo json_encode($result);
	 }else{
		 $response["status"] =2;
        $response["error_msg"] = "Wrong data. Please try again!";
        echo json_encode($response);
	 }
}else{
	// required post params is missing
    $response["status"] =3;
    $response["error_msg"] = "Required parameters longitude and latitude is missing!";
    echo json_encode($response);
}
 ?>