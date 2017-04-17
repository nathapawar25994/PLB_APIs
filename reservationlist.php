<?php
require_once 'DB_Functions.php';
$db = new DB_Functions();
if (!isset($_POST['user_id'] )) {
	    $response["status"] =false;
	    $response["error_msg"] = "User id is missing";
	    echo json_encode($response);
}else  if(!isset($_POST['parking_id'] )){
	    $response["status"] =false;
	    $response["error_msg"] = "Parking id is missing";
	    echo json_encode($response);
}else {
	 
	 $user_id=$_POST['user_id'];
	 $parking_id=$_POST['parking_id'];
	 $result = $db->getreservationlist($user_id,$parking_id);
	 if ($result != false) {
		 $response["status"] =1;
	    $response["msg"] = "Reservation loaded successfully!";
		$data=array();
		$i=0;
		while($user=$result->fetch_assoc()){
			
        $data[$i]['id']=$user['reserve_id'];
		$data[$i]['from_time']=$user['from_time'];
		$data[$i]['to_time']=$user['to_time'];
		$data[$i]['lot_no']=$user['lot_no'];
		$data[$i]['like_dislike']=$user['like_dislike'];
		$data[$i]['parking_owner']=$user['parking_owner'];
		$data[$i]['lot_name']=$user['lot_name'];
		$data[$i]['landmark']=$user['landmark'];
		$data[$i]['city']=$user['city'];
		$data[$i]['province']=$user['province'];
		$data[$i]['country']=$user['country'];
		$data[$i]['landmark']=$user['landmark'];
		$data[$i]['latitude']=$user['latitude'];
		$data[$i]['longitude']=$user['longitude'];
		$data[$i]['is_complex']=$user['is_complex'];
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