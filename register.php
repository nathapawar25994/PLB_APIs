<?php
 
require_once 'DB_Functions.php';
$db = new DB_Functions();
 
// json response array

 if (isset($_POST['full_name']) && isset($_POST['email_id']) && isset($_POST['mobile_no']) && isset($_POST['password'])) {
 
    // receiving the post params
    $name =$_POST['full_name'];
    $email =$_POST['email_id'];
    $mobile_no=$_POST['mobile_no'];
    $password =$_POST['password'];
	$bike_numbers=$_POST['bike_numbers'];
 
    // check if user is already existed with the same email
    if ($db->isUserExisted($email)) {
        // user already existed
        $response["status"] = 4;
        $response["error_msg"] = "User already existed with " . $email;
        echo json_encode($response);
    } else {
        // create a new user
        $user = $db->storeUser($name, $email, $mobile_no,$password,$bike_numbers);
        
        if ($user) {
            // user stored successfully
            $response["status"] =1;
            
            $response["user"]["full_name"] = $user["full_name"];
            $response["user"]["email_id"] = $user["email_id"];
            $response["user"]["mobile_no"]=$user["mobile_no"];
            $response["user"]["password"]=$user["password"];
			$response["user"]["bike_numbers"]=$user["bike_numbers"];
            echo json_encode($response);
        } else {
            // user failed to store
            $response["status"] =2;
            $response["error_msg"] = "Unknown error occurred in registration!";
            echo json_encode($response);
        }
    }
} else {
    $response["status"] =3;
    $response["error_msg"] = "Required parameters (name, email,mobile no or password) is missing!";
    echo json_encode($response);
}
?>