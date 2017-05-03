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
	 $result = $db->get_list($user_id,$parking_id);
	 if ($result != false) {
		 $response["status"] =1;
	    $response["msg"] = "Reservation loaded successfully!";
		$data=array();
		$i=0;
		while($user=$result->fetch_assoc()){
			
        $data[$i]['id']=$user['user_id'];
		$data[$i]['status']=$user['status'];
		$data[$i]['lot_name']=$user['lot_name'];
		$data[$i]['lot_no']=$user['lot_no'];
		$data[$i]['reserv_date']=$user['reserv_date'];
		$data[$i]['from_time']=$user['from_time'];
		
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