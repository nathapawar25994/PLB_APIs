<?php
require_once 'DB_Functions.php';
$db = new DB_Functions();
 
// json response array


if (isset($_POST['email_id'] ) && isset($_POST['password'])) {
 
    // receiving the post params
    $email =$_POST['email_id'];
    $password =$_POST['password'];
   
    // get the user by email and password
    $user = $db->getUserByEmailAndPassword($email, $password);
 
    if ($user != false) {
        // use is found
        $response["status"] =1;
        $response["user"]["full_name"] = $user["full_name"];
        $response["user"]["email_id"] = $user["email_id"];
        $response["user"]["mobile_no"]=$user["mobile_no"];
		$response["user"]["miles"]=$user["miles"];
		$response["user"]["bike_numbers"]=$user["bike_numbers"];
        //$response["user"]["password"]=$user["password"];
        echo json_encode($response);
    } else {
        // user is not found with the credentials
        $response["status"] =2;
        $response["error_msg"] = "Login credentials are wrong. Please try again!";
        echo json_encode($response);
    }
} else {
    // required post params is missing
    $response["status"] =3;
    $response["error_msg"] = "Required parameters email or password is missing!";
    echo json_encode($response);
}
?>