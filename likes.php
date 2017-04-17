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
}else if(!isset($_POST['reserve_id'] )){
	    $response["status"] =false;
	    $response["error_msg"] = "Reserve id is missing";
	    echo json_encode($response);
}else {
	 
	 $user_id=$_POST['user_id'];
	 $parking_id=$_POST['parking_id'];
	 $reserve_id=$_POST['reserve_id'];
	 $result = $db->updatelikedislike($user_id,$parking_id,$reserve_id);
	 if ($result != false) {
		 $response["status"] =1;
	    $response["msg"] = "Liked";
		$data=array();
	 echo json_encode($response);
	 }else{
		 $response["status"] =2;
        $response["msg"] = "Wrong data. Please try again!";
        echo json_encode($response);
	 }
}

 ?>