<?php
require_once 'include/DbHandler.php';
require_once 'include/PassHash.php';
require 'Slim/Slim.php';

\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();

$app->get('/requestedparking/:input', function($input) {
           
           $response = array();
           $db = new DbHandler();
            $data = $db->requested_parking($input);
           
            if ($data != NULL) {
                $response["error"] = false;
                $response["message"] = "Data loaded successfully";
                $response["data"] = $data;
                jsonResponse(200,$response);
            } else {
                $response["error"] = true;
                $response["message"] = "Wrong input. Please try again";
                jsonResponse(200,$response);
            }    
        });

$app->get('/attendantlist/:input', function($input) {
           
           $response = array();
           $db = new DbHandler();
            $data= $db->attendant_list($input);
           
            if ($data != NULL) {
                $response["error"] = false;
                $response["message"] = "Data loaded successfully";
                $response["data"] = $data;
                jsonResponse(200,$response);
            } else {
                $response["error"] = true;
                $response["message"] = "Wrong input. Please try again";
                jsonResponse(200,$response);
            }    
        });

$app->post('/login', function() use ($app) {
            
           $response = array();
       $db = new DbHandler();
       $email = $app->request->post('email');
       $password = $app->request->post('password');
          $data = $db->get_User_By_EmailAndPassword($email,$password);

            if ($data != NULL) {
                $response["error"] = false;
                $response["message"] = "Logged in successfully";
                $response["data"] = $data;
                jsonResponse(200,$response);
            } else {
                $response["error"] = true;
                $response["message"] = "Login credetianls are wrong. Please try again";
                jsonResponse(200,$response);
            }    
           
        });
        



$app->post('/confirmparking', function() use($app) {

            $response = array();
             $db = new DbHandler();
       $parking_id = $app->request->post('parking_id');
       $user_id = $app->request->post('user_id');
       $reserve_id = $app->request->post('reserve_id');
       
          $data = $db->confirm_parking($parking_id,$user_id,$reserve_id);

            
            if ($data !=NULL) {
                // Updated successfully
                $response["error"] = false;
                $response["message"] = "Parking confirmed successfully";
            } else {
                // Failed to update
                $response["error"] = true;
                $response["message"] = "Failed to update. Please try again!";
            }
            jsonResponse(200, $response);
        });

  $app->post('/cancelparking', function() use($app) {

            $response = array();
             $db = new DbHandler();
       $parking_id = $app->request->post('parking_id');
       $user_id = $app->request->post('user_id');
       $reserve_id = $app->request->post('reserve_id');
       
          $data = $db->cancel_parking($parking_id,$user_id,$reserve_id);

            
            if ($data !=NULL) {
                // Updated successfully
                $response["error"] = false;
                $response["message"] = "Parking canceled successfully";
            } else {
                // Failed to update
                $response["error"] = true;
                $response["message"] = "Failed to update. Please try again!";
            }
            jsonResponse(200, $response);
        });

$app->delete('/deleteSomething', function() use($app) {
           
            $response = array();
            $input = $app->request->put('input'); // reading post params
            
			// add your business logic here
            $result = true;
            if ($result) {
                //deleted successfully
                $response["error"] = false;
                $response["message"] = "Deleted succesfully";
            } else {
                //failed to delete
                $response["error"] = true;
                $response["message"] = "Failed to delete. Please try again!";
            }
            jsonResponse(200, $response);
        });
        

function jsonResponse($status_code, $response) {
    
    $app = \Slim\Slim::getInstance();
    $app->status($status_code);
	$app->contentType('application/json');

    echo json_encode($response);
}
        
$app->run();

?>
