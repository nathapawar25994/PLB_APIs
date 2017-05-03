<?php
require_once 'DB_Functions.php';
$db = new DB_Functions();
if (isset($_POST['parking_id'] ) && isset($_POST['reserv_date'])) {
	 $parking_id=$_POST['parking_id'];
	 $date=$_POST['reserv_date'];
	 $result = $db->getreservedlots($parking_id,$date);
	 $result1 = $db->get_lots_by_date($parking_id,$date);
	 if ($result1 != false) {
		
		$data=array();
		while($user=$result1->fetch_assoc()){
		$data['two_wheeler']=$user['two_wheeler'];
		$data['car_parking']=$user['car_parking'];
		$data['heavy_vehicles']=$user['heavy_vehicles'];
		
		}
		$response=$data;
		$response["status"] =1;
	    $response["msg"] = "Reserved lots founded successfully!";
	 }else{
		 $response["status"] =2;
        $response["error_msg"] = "Wrong data. Please try again!";
        echo json_encode($response);
	 }
	 if ($result != false) {
		 
	    
		$i=0;
		$data=array();
		while($user=$result->fetch_assoc()){
		$data[$i]['lot_no']=$user['lot_no'];
		$i++;
		}
		$response['reserved_lots']=$data;
	 
	 }
	 echo json_encode($response);
}else{
	// required post params is missing
    $response["status"] =3;
    $response["msg"] = "Required parameters Parking Id and reserv_date is missing!";
    echo json_encode($response);
}
 ?>
