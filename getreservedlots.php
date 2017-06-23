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
		$data['two_wheeler_rate']=$user['two_wheeler_rate'];
		$data['car_parking_rate']=$user['car_parking_rate'];
		$data['heavy_vehicles_rate']=$user['heavy_vehicles_rate'];
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
		$j=0;
		$k=0;
		$p=0;
		
		$bike=array();
		$car=array();
		$truck=array();
		while($user=$result->fetch_assoc()){
		//$bike[$i]['lot_no']=$user['lot_no'];
		if($user['vehical_type']=='bike'){
			$bike[$j]['lot_no']=$user['lot_no'];
			$j++;
		}else if($user['vehical_type']=='car'){
			$car[$k]['lot_no']=$user['lot_no'];
			$k++;
		}else if($user['vehical_type']=='truck'){
			$truck[$p]['lot_no']=$user['lot_no'];
			$p++;
		}
		$i++;
		}
		$response['reserved_lots']=$bike;
		$response['car_lots']=$car;
		$response['truck_lots']=$truck;
	 
	 }
	 echo json_encode($response);
}else{
	// required post params is missing
    $response["status"] =3;
    $response["msg"] = "Required parameters Parking Id and reserv_date is missing!";
    echo json_encode($response);
}
 ?>
