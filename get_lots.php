<?php
require_once 'DB_Functions.php';
$db = new DB_Functions();
if (isset($_POST['parking_id'] )) {
	 $parking_id=$_POST['parking_id'];
	
	 $result1 = $db->get_lots($parking_id);
	 if ($result1 != false) {
		
		$data=array();
		$user=$result1->fetch_assoc();
		$data['two_wheeler']=$user['two_wheeler'];
		$data['car_parking']=$user['car_parking'];
		$data['heavy_vehicles']=$user['heavy_vehicles'];
		$response=$data;
		$response["status"] =1;
	    $response["msg"] = "Reserved lots founded successfully!";
		echo json_encode($response);
	 }else{
		 $response["status"] =2;
        $response["error_msg"] = "Wrong data. Please try again!";
        echo json_encode($response);
	 }
	
	 
}else{
	// required post params is missing
    $response["status"] =3;
    $response["msg"] = "Required parameters Parking Id  is missing!";
    echo json_encode($response);
}
 ?>
