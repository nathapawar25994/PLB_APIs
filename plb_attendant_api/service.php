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
//attendant List API
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
		//Get tokens List
		$app->post('/allocated_list', function() use ($app) {
            
           $response = array();
       $db = new DbHandler();
       $parking_id = $app->request->post('parking_id');
       
          $data = $db->allocated_list($parking_id);

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
		// Allocate Parikng status=1
		$app->post('/allocate_parking', function() use ($app) {
            
           $response = array();
       $db = new DbHandler();
       $reserve_id = $app->request->post('reserve_id');
	   $token = $app->request->post('token');
       
          $data = $db->allocate_parking($reserve_id,$token);

            if ($data != NULL) {
                $response["error"] = false;
                $response["message"] = "Parking Confirmed";
                jsonResponse(200,$response);
            } else {
                $response["error"] = true;
                $response["message"] = "Confirmation failed. Please try again";
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
        


$app->post('/allocationlist', function() use($app) {

            $response = array();
             $db = new DbHandler();
       $parking_id = $app->request->post('parking_id');
       
       $reserve_date = $app->request->post('reserve_date');
       
          $data = $db->get_all_list_of_booked_parking($parking_id,$reserve_date);

            
            if ($data !=NULL) {
                // Updated successfully
                $response["error"] = false;
                $response["message"] = "Allocation list loaded successfully";
				$response["data"]=$data;
            } else {
                // Failed to update
                $response["error"] = true;
                $response["message"] = "Failed to load. Please try again!";
            }
            jsonResponse(200, $response);
        });
		$app->post('/deallocationlist', function() use($app) {

            $response = array();
             $db = new DbHandler();
       $parking_id = $app->request->post('parking_id');
       
       $reserve_date = $app->request->post('reserve_date');
       
          $data = $db->get_all_list_of_booked_confirmed_parking($parking_id,$reserve_date);

            
            if ($data !=NULL) {
                // Updated successfully
                $response["error"] = false;
                $response["message"] = "De-Allocation list loaded successfully";
				$response["data"]=$data;
            } else {
                // Failed to update
                $response["error"] = true;
                $response["message"] = "Failed to load. Please try again!";
            }
            jsonResponse(200, $response);
        });
		
$app->post('/confirmparking', function() use($app) {

            $response = array();
             $db = new DbHandler();
       $parking_id = $app->request->post('parking_id');
       
       $reserve_id = $app->request->post('reserve_id');
       
          $data = $db->confirm_parking($parking_id,$reserve_id);

            
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
      
       $reserve_id = $app->request->post('reserve_id');
       
          $data = $db->cancel_parking($parking_id,$reserve_id);

            
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
		
		$app->post('/rejectparking', function() use($app) {

            $response = array();
             $db = new DbHandler();
       $reserve_id = $app->request->post('reserve_id');
       
          $data = $db->reject_parking($reserve_id);

            
            if ($data !=NULL || $data==true) {
                // Updated successfully
                $response["error"] = false;
                $response["message"] = "Parking Rejected successfully";
            } else {
                // Failed to update
                $response["error"] = true;
                $response["message"] = "Failed to reject. Please try again!";
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
