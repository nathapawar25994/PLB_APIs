<?php
require_once 'DB_Functions.php';
$db = new DB_Functions();
 	 
	 $result = $db->countsoflots();
	 if ($result != false) {
		 $response["status"] =1;
	    $response["msg"] = "Counts loaded successfully!";
		$data=array();
		$i=0;
		while($user=$result->fetch_assoc()){
		$data[$i]['lot_no']=$user['lot_no'];
		$data[$i]['parking_id']=$user['parking_id'];
		$i++;
		}
		$response['data']=$data;
	 echo json_encode($response);
	 }else{
		 $response["status"] =2;
        $response["msg"] = "Wrong data. Please try again!";
        echo json_encode($response);
	 }


 ?>