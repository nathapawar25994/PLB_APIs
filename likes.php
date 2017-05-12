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
}else if(!isset($_POST['status'] )){
	    $response["status"] =false;
	    $response["error_msg"] = "status is missing";
	    echo json_encode($response);
}else{
	 
	 $user_id=$_POST['user_id'];
	 $parking_id=$_POST['parking_id'];
	 $status=$_POST['status'];
	 $result = $db->updatelikedislike($user_id,$parking_id,$status);
	
	
	 if ($result==0) {
		$response["status"] =0;
	    $response["msg"] = "Liked";
		
	 echo json_encode($response);
	 }else if($result==1){
		  $response["status"] =1;
          $response["msg"] = "failed to like this parking";
          echo json_encode($response);
	 }else if($result==2){
		  $response["status"] =2;
          $response["msg"] = "Dis-Liked";
          echo json_encode($response);
	 }else{
		  $response["status"] =3;
          $response["msg"] = "Wrong data. Please try again!";
          echo json_encode($response);
	 }
}

 ?>