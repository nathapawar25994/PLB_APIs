<?php
require_once 'DB_Functions.php';
$db = new DB_Functions();
if (!isset($_POST['user_id'] )) {
	    $response["status"] =false;
	    $response["error_msg"] = "User id is missing";
	    echo json_encode($response);
}else   {
	 
	 $user_id=$_POST['user_id'];
	 
	 $result = $db->get_list($user_id);
	 if ($result != false) {
		 $response["status"] =1;
	    $response["msg"] = "Reservation loaded successfully!";
		$response['data']=$result;
	 echo json_encode($response);
	 }else{
		 $response["status"] =2;
        $response["msg"] = "Wrong data. Please try again!";
        echo json_encode($response);
	 }
}

 ?>