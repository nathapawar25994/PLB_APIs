<?php
require_once 'DB_Functions.php';
$db = new DB_Functions();
if (isset($_POST['user_id'] ) && isset($_POST['bike_numbers'])) {
	 
	 $user_id=$_POST['user_id'];
	 $bike_numbers=$_POST['bike_numbers'];
	 $result = $db->update_bike_numbers($user_id,$bike_numbers);
	 if ($result != false) {
		 $response["status"] =1;
	    $response["error_msg"] = "bike_number updated successfully!";
		
	 echo json_encode($response);
	 }else{
		 $response["status"] =2;
        $response["error_msg"] = "Wrong data. Please try again!";
        echo json_encode($response);
	 }
}else{
	// required post params is missing
    $response["status"] =3;
    $response["error_msg"] = "Required parameters user_id and bike_numbers is missing!";
    echo json_encode($response);
}
 ?>