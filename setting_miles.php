<?php
require_once 'DB_Functions.php';
$db = new DB_Functions();
if (isset($_POST['user_id'] ) && isset($_POST['miles'])) {
	 
	 $user_id=$_POST['user_id'];
	 $miles=$_POST['miles'];
	 $result = $db->update_miles($user_id,$miles);
	 if ($result != false) {
		 $response["status"] =1;
	    $response["error_msg"] = "Miles updated successfully!";
		
	 echo json_encode($response);
	 }else{
		 $response["status"] =2;
        $response["error_msg"] = "Wrong data. Please try again!";
        echo json_encode($response);
	 }
}else{
	// required post params is missing
    $response["status"] =3;
    $response["error_msg"] = "Required parameters user_id and miles is missing!";
    echo json_encode($response);
}
 ?>