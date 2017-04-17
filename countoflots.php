<?php
require_once 'DB_Functions.php';
$db = new DB_Functions();
 if(!isset($_POST['parking_id'] )){
	    $response["status"] =false;
	    $response["error_msg"] = "Parking id is missing";
	    echo json_encode($response);
}else {
	 
	 $parking_id=$_POST['parking_id'];
	 $result = $db->countsoflots($parking_id);
	 if ($result != false) {
		 $response["status"] =1;
	    $response["msg"] = "Counts loaded successfully!";
		$data=array();
		$i=0;
		while($user=$result->fetch_assoc()){
		$data[$i]['lot_no']=$user['lot_no'];
		$data[$i]['parking_owner']=$user['parking_owner'];
		$data[$i]['lot_name']=$user['lot_name'];
		$data[$i]['two_wheeler']=$user['two_wheeler'];
		$data[$i]['car_parking']=$user['car_parking'];
		$data[$i]['heavy_vehicles']=$user['heavy_vehicles'];
		$data[$i]['status']=$user['status'];
		$i++;
		}
		$response['data']=$data;
	 echo json_encode($response);
	 }else{
		 $response["status"] =2;
        $response["msg"] = "Wrong data. Please try again!";
        echo json_encode($response);
	 }
}

 ?>