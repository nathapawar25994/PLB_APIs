<?php
require_once 'DB_Functions.php';
$db = new DB_Functions();
if (isset($_POST['email_id'] ) && isset($_POST['token'] ) && isset($_POST['password'] )) {
	 
	 $email_id=$_POST['email_id'];
	 $token=$_POST['token'];
	 $password=$_POST['password'];
	 $data = $db->enter_otp($email_id,$token,$password);
	 
	 if ($data==1) {
                $response["error"] = false;
                $response["message"] = "Correct OTP";
                echo json_encode($response);
            } else {
                $response["error"] = true;
                $response["message"] = "Please enter vallid OTP. And Please try again";
                echo json_encode($response);
            }   
}else{
	// required post params is missing
    $response["status"] =3;
    $response["error_msg"] = "Required parameters user_id and bike_numbers is missing!";
    echo json_encode($response);
}
 ?>