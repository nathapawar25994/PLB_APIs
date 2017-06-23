<?php
require_once 'DB_Functions.php';
$db = new DB_Functions();
if (isset($_POST['user_id'] )) {
	 $user_id=$_POST['user_id'];
	 $result = $db->get_fav_list($user_id);
	 if ($result != false) {
		 $response["status"] =1;
	     $response["error_msg"] = "Favourite list found!";
		 $response['data']=$result;
	     echo json_encode($response);
	 }else{
		$response["status"] =2;
        $response["error_msg"] = "Wrong data. Please try again!";
		echo json_encode($response);
	 }
}else{
	// required post params is missing
    $response["status"] =3;
    $response["error_msg"] = "Required parameters longitude and latitude is missing!";
    echo json_encode($response);
}
 ?>