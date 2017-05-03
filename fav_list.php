<?php
require_once 'DB_Functions.php';
$db = new DB_Functions();
if (isset($_POST['user_id'] )) {
	 $user_id=$_POST['user_id'];
	 $result = $db->get_fav_list($user_id);
	 if ($result != false) {
		 $response["status"] =1;
	    $response["error_msg"] = "Favourite list found!";
		$i=0;
		
		$data=array();
		while($user=$result->fetch_assoc()){
			
        $data[$i]['id']=$user['id'];
		$data[$i]['parking_owner']=$user['parking_owner'];
		$data[$i]['lot_name']=$user['lot_name'];
		$data[$i]['landmark']=$user['landmark'];
		$data[$i]['city']=$user['city'];
		$data[$i]['province']=$user['province'];
		$data[$i]['country']=$user['country'];
		$data[$i]['landmark']=$user['landmark'];
		$data[$i]['latitude']=$user['latitude'];
		$data[$i]['longitude']=$user['longitude'];
		$data[$i]['is_complex']=$user['is_complex'];
		$data[$i]['two_wheeler']=$user['two_wheeler'];
		$data[$i]['car_parking']=$user['car_parking'];
		$data[$i]['heavy_vehicles']=$user['heavy_vehicles'];
		$data[$i]['status']=$user['status'];
		$i++;
		}
		$response=$data;
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