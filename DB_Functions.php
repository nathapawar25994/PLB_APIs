
<?php

// abc

class DB_Functions

	{
	private $conn;

	// constructor

	function __construct()
		{
		require_once 'DB_Connect.php';

		// connecting to database

		$db = new Db_Connect();
		$this->conn = $db->connect();
		}

	// destructor

	function __destruct()
		{
		}

	/**
	 * Storing new user
	 * returns user details
	 */
	public

	function storeUser($full_name, $email, $mobile_no, $password, $bike_numbers)
		{
		$query = "insert into users(full_name,email_id,mobile_no,password,miles,bike_numbers)values('" . $full_name . "','" . $email . "','" . $mobile_no . "','" . md5($password) . "','5','" . $bike_numbers . "')";
		$result = $this->conn->query($query);
		$last_id = $this->conn->insert_id;
		if ($result)
			{
			$sql = "SELECT * from users where email_id='" . $email . "'";
			$res = $this->conn->query($sql);
			$user = $res->fetch_assoc();
			$user['user_id'] = $last_id;
			return $user;
			}
		  else
			{
			return false;
			}
		}

	public

	function reservLot($from_time, $to_time, $lot_no, $user_id, $parking_id, $reserv_date)
		{
			$sql = "select * from reservlot rl WHERE  rl.user_id='" . $user_id . "' and rl.lot_no='" . $lot_no . "' and rl.parking_id='" . $parking_id . "' and rl.reserv_date='" . $reserv_date . "'";
		$res = $this->conn->query($sql);
			if(mysqli_num_rows($res)>0){
				return 2;
			}else{
			
		$status = 0;
		$query = "insert into reservlot(user_id,parking_id,from_time,to_time,lot_no,reserv_date,status)values('" . $user_id . "','" . $parking_id . "','" . $from_time . "','" . $to_time . "','" . $lot_no . "','" . $reserv_date . "','" . $status . "')";
		$result = $this->conn->query($query);
		if ($result)
			{
			return 1;
			}
		  else
			{
			return false;
			}
		}
	}

	public

	function updatereservLot($from_time, $to_time, $lot_no, $user_id, $parking_id, $res_id, $reserv_date)
		{
		$query = "update reservlot set user_id='" . $user_id . "',parking_id='" . $parking_id . "',from_time='" . $from_time . "',to_time='" . $to_time . "',lot_no='" . $lot_no . "',reserv_date='" . $reserv_date . "' where reserve_id='" . $res_id . "' ";
		$result = $this->conn->query($query);
		if ($result)
			{
			return $result;
			}
		  else
			{
			return false;
			}
		}

	public

	function getreservationlist($user_id, $parking_id)
		{
		$sql = "select rl.*,plm.* from reservlot rl,parking_lot_master plm WHERE rl.parking_id=plm.id and rl.user_id='" . $user_id . "' and rl.parking_id='" . $parking_id . "'";
		$res = $this->conn->query($sql);
		if ($res)
			{
			return $res;
			}
		  else
			{
			return false;
			}
		}

	public

	function get_list($user_id)
		{
         $sql1="select parking_id from reservlot where user_id='".$user_id."'";
		$res1 = $this->conn->query($sql1); 
		 $i=0;
		 $data1=array();
		 while($user=$res1->fetch_assoc()){
		 $data1[$i]=$user['parking_id'];
		 $i++;
		 }
		 $response=array();
		 
		 $uniq=array();
		 $temp=array();
		 $p=0;
		 $s=0;
		 $uniq=array_unique($data1);
		 foreach($uniq as $value){
			 $temp[$p]=$value;
			 $p++;
		 }
		 //print_r($temp);die();
		for($j=0;$j<count($temp);$j++){
			
			$parking_id=$temp[$j];
		$sql = "select  rl.user_id,rl.status,plm.latitude,plm.longitude,plm.lot_name,rl.lot_no,rl.reserv_date,rl.from_time from reservlot rl,parking_lot_master plm WHERE rl.parking_id=plm.id and rl.user_id='" . $user_id . "' and rl.parking_id='" .$parking_id. "'";
		
		$res = $this->conn->query($sql);
		
		$data=array();
		$k=0;
		          while($user1=$res->fetch_assoc()){
					  
				    $data[$k]['id']=$user1['user_id'];
					$data[$k]['status']=$user1['status'];
					$data[$k]['lot_name']=$user1['lot_name'];
					$data[$k]['lot_no']=$user1['lot_no'];
					$data[$k]['latitude']=$user1['latitude'];
					$data[$k]['longitude']=$user1['longitude'];
					$data[$k]['reserv_date']=$user1['reserv_date'];
					$data[$k]['from_time']=$user1['from_time'];
				  $k++;
				 }
				    $response[$s]['data']=$data;
				 $s++;
					
		     }
			 
		 return $response;
		}

	public 	function countsoflots()
		{
		$today=date('Y-m-d');
		$sql = "select rl.lot_no,rl.parking_id from reservlot rl WHERE reserv_date='".$today."' and rl.status=1";
		
		$res = $this->conn->query($sql);
		if (mysqli_num_rows($res) > 0)
			{
				
			return $res;
			}
		  else
			{
			return false;
			}
		}
	public

	function getreservedlots($parking_id, $date)
		{
		$sql = "SELECT reservlot.lot_no,reservlot.vehical_type,parking_lot_master.two_wheeler,parking_lot_master.car_parking,parking_lot_master.heavy_vehicles FROM `parking_lot_master`,reservlot where parking_lot_master.id=reservlot.parking_id and reservlot.parking_id='" . $parking_id . "' and reserv_date='" . $date . "' and parking_lot_master.status=1 and reservlot.status=1";
		$res = $this->conn->query($sql);
		if (mysqli_num_rows($res) != 0)
			{
			return $res;
			}
		  else
			{
			return false;
			}
		}

	public

	function get_lots_by_date($parking_id, $date)
		{
		$sql = "SELECT parking_lot_master.two_wheeler,parking_lot_master.car_parking,parking_lot_master.heavy_vehicles  FROM `parking_lot_master` where id='" . $parking_id . "' and status=1";
		$res = $this->conn->query($sql);
		if (mysqli_num_rows($res) != 0)
			{
			return $res;
			}
		  else
			{
			return false;
			}
		}

	public

	function get_fav_list($user_id)
		{
		$i=0;
		$data=array();
		$sql = "SELECT DISTINCT  parking_id FROM like_dislike where user_id='" . $user_id . "' and status=1";
		$res = $this->conn->query($sql);
		if (mysqli_num_rows($res) != 0){
		while($user1=$res->fetch_assoc()){
		
		$parking_id = $user1['parking_id'];
		$sql1 = "SELECT * FROM parking_lot_master where id='" . $parking_id . "' and status=1";
		$result = $this->conn->query($sql1);
		if (mysqli_num_rows($result) != 0){
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
		
		}
		$i++;
		}
			
		}
		  return $data;
		}else{
			return false;
		}
		}
     
	   function get_lots($parking_id)
		{
		
		$sql1 = "SELECT * FROM parking_lot_master where id='" . $parking_id . "' and status=1";
		$result = $this->conn->query($sql1);
		if (mysqli_num_rows($result) != 0)
			{
			return $result;
			}
		  else
			{
			return false;
			}
		}
	 
	public

	function updatelikedislike($user_id, $parking_id, $status)
		{
		if ($status == 0)
			{
			$query = "update like_dislike set status=0 where user_id='" . $user_id . "' and parking_id='" . $parking_id . "'";
			$temp = 0;
			$result = $this->conn->query($query);
			}
		  else
			{
			$query = "insert into like_dislike(parking_id,user_id,status)values('" . $parking_id . "','" . $user_id . "','" . $status . "')";
			$temp = 1;
			$result = $this->conn->query($query);
			}

		if ($temp == 1)
			{
			if ($result)
				{
					
				return 0;
				}
			  else
				{
				return 1;
				}
			}
		  else
			{
			if ($this->conn->affected_rows > 0)
				{
					 
				return 2;
				}
			  else
				{
					
				return 3;
				}
			}
		}

	public

	function update_miles($user_id, $miles)
		{
		$query = "update users set miles='" . $miles . "' where user_id='" . $user_id . "'";
		$result = $this->conn->query($query);
		if ($result)
			{
			return $result;
			}
		  else
			{
			return false;
			}
		}

	public

	function update_bike_numbers($user_id, $bike_numbers, $miles)
		{
		$query = "update users set bike_numbers='" . $bike_numbers . "',miles='" . $miles . "' where user_id='" . $user_id . "'";
		$result = $this->conn->query($query);
		if ($result)
			{
			return $result;
			}
		  else
			{
			return false;
			}
		}

	public

	function findlocation($long, $lat, $user_id)
		{
			
		$result = $this->conn->query("SELECT miles FROM users
 WHERE user_id='" . $user_id . "' ");
		while ($user = $result->fetch_assoc())
			{
			$miles = $user['miles'];
			}
			
		  $sql2 = "select * from like_dislike where user_id = '".$user_id."' and status=1";
		  $res2 = $this->conn->query($sql2);
		  $data1=array();
		  $i=0;
		while($user1=$res2->fetch_assoc()){
		$data1[$i]=$user1['parking_id'];
		 $i++;
		}
		 
		  $sql3 = "select lot_no from reservlot where user_id = '".$user_id."' and status=1";
		  $res3 = $this->conn->query($sql3);
		  $data3=array();
		  $k=0;
		while($user2=$res3->fetch_assoc()){
		$data3[$k]=$user2['lot_no'];
		 $k++;
		}
		  
		 $commaList = implode(', ',$data1);
		$sql = "SELECT *, ( 3959 * acos( cos( radians('" . $lat . "') ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians('" . $long . "') ) + sin( radians('" . $lat . "') ) * sin( radians( latitude ) ) ) ) AS distance FROM parking_lot_master WHERE STATUS =1 HAVING distance < " . $miles . " ORDER BY distance LIMIT 0 , 20";
		$res = $this->conn->query($sql);
		$data=array();
		
		if(mysqli_num_rows($res)>0){
			$response["status"] =1;
	    $response["error_msg"] = "Location founded successfully!";
		$i=0;
		while($user=$res->fetch_assoc()){
			
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
		$response['parking_ids']=$commaList;
		$response['data']=$data;
		$response['lots']=$data3;
		return $response;
		 }else{
			  return false;
		     }
		}

	/**
	 * Get user by email and password
	 */
	public function getUserByEmailAndPassword($email, $password)
		{
		$email = $email;
		$res = $this->conn->query("SELECT * FROM users WHERE email_id ='" . $email . "'");
		if ($res)
			{
			$user = $res->fetch_assoc();
			$encrypted_password = $user['password'];

			// check for password equality

			$org_pass = md5($password);
			if ($encrypted_password == $org_pass)
				{

				// user authentication details are correct

				return $user;
				}
			}
		  else
			{
			return NULL;
			}
		}
		
		public function send_mail($email_id) {
        $token=rand(111111,999999);
         $query="update users set forgot_token='".$token."'  where email_id='".$email_id."'";
        $res = $this->conn->query($query);
        
        if ($this->conn->affected_rows>0) {
			$to      = $email_id;
			$subject = 'Your Forgot Password Token';
            $message = "Enter this token to reset your password-".$token;
            $headers = 'From: info@deltabee.com' . "\r\n" .
            'Reply-To: info@deltabee.com' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

           mail($to, $subject, $message, $headers);
			
			
            return 1;
        } else {
            return NULL;
        }
    }
		
      public function enter_otp($email_id,$token,$password) {
		$query1="select forgot_token from users where email_id='".$email_id."' ";
         $res1 = $this->conn->query($query1);
		 $user=$res1->fetch_assoc();
		 $tok=$user['forgot_token'];
		 if($tok==$token){
         $query="update users set forgot_token='',password='".md5($password)."'  where email_id='".$email_id."' ";
         
		 $res = $this->conn->query($query);
        if ($this->conn->affected_rows>0) {
            return 1; 
		 }else {
            return NULL;
        }
		 }else{
			 return 0;
		 }
    }
	/**
	 * Check user is existed or not
	 */
	public 	function isUserExisted($email)
		{
		$stmt = $this->conn->prepare("SELECT email_id from users WHERE email_id = ?");
		$stmt->bind_param("s", $email);
		$stmt->execute();
		$stmt->store_result();
		if ($stmt->num_rows > 0)
			{

			// user existed

			$stmt->close();
			return true;
			}
		  else
			{

			// user not existed

			$stmt->close();
			return false;
			}
		}
	}

?>


 