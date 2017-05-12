<?php
require_once 'DB_Functions.php';
$db = new DB_Functions();
if (isset($_POST['email_id'] )) {
	 
	 $email_id=$_POST['email_id'];
	 $data = $db->send_mail($email_id);
	 
	 if ($data ==1) {
                $response["error"] = false;
                $response["message"] = "Mail sent on your email id";
                echo json_encode($response);
            } else {
                $response["error"] = true;
                $response["message"] = "Please enter registered email id. And Please try again";
                echo json_encode($response);
            }   
}else{
	// required post params is missing
    $response["status"] =3;
    $response["error_msg"] = "Required parameters user_id and bike_numbers is missing!";
    echo json_encode($response);
}
 ?>