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
}else if(!isset($_POST['from_time'] )){
	    $response["status"] =false;
	    $response["error_msg"] = "from time is missing";
	    echo json_encode($response);
}else if(!isset($_POST['to_time'] )){
	    $response["status"] =false;
	    $response["error_msg"] = "To time is missing";
	    echo json_encode($response);
}else if(!isset($_POST['lot_no'] )){
	    $response["status"] =false;
	    $response["error_msg"] = "lot_no is missing";
	    echo json_encode($response);
}else{	 
     $from_time=$_POST['from_time'];
	 $to_time=$_POST['to_time'];
	 $lot_no=$_POST['lot_no'];
	 $user_id=$_POST['user_id'];
	 $parking_id=$_POST['parking_id'];
	 $reserv_date=$_POST['reserv_date'];
	 $user = $db->reservLot($from_time,$to_time,$lot_no,$user_id,$parking_id,$reserv_date);
	 if ($user != false) {
		 $response["status"] =1;
	    $response["error_msg"] = "Lot added successfully!";
	 echo json_encode($response);
	 }else{
		 $response["status"] =2;
        $response["error_msg"] = "Wrong data. Please try again!";
        echo json_encode($response);
	 }
}
 ?>