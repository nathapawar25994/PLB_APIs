
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
		$status = 0;
		$query = "insert into reservlot(user_id,parking_id,from_time,to_time,lot_no,reserv_date,status)values('" . $user_id . "','" . $parking_id . "','" . $from_time . "','" . $to_time . "','" . $lot_no . "','" . $reserv_date . "','" . $status . "')";
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

	function get_list($user_id, $parking_id)
		{
		$sql = "select rl.user_id,rl.status,plm.lot_name,rl.lot_no,rl.reserv_date,rl.from_time from reservlot rl,parking_lot_master plm WHERE rl.parking_id=plm.id and rl.user_id='" . $user_id . "' and rl.parking_id='" . $parking_id . "'";
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

	function countsoflots($parking_id)
		{
		$sql = "select rl.lot_no,rl.status,plm.parking_owner,plm.lot_name,plm.two_wheeler,plm.car_parking,plm.heavy_vehicles from reservlot rl,parking_lot_master plm WHERE rl.parking_id=plm.id and rl.parking_id='" . $parking_id . "' and plm.id='" . $parking_id . "' and plm.status=1";
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

	function getreservedlots($parking_id, $date)
		{
		$sql = "SELECT reservlot.lot_no,parking_lot_master.two_wheeler,parking_lot_master.car_parking,parking_lot_master.heavy_vehicles FROM `parking_lot_master`,reservlot where parking_lot_master.id=reservlot.parking_id and reservlot.parking_id='" . $parking_id . "' and reserv_date='" . $date . "' and parking_lot_master.status=1 and reservlot.status=1";
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
		$sql = "SELECT parking_id FROM like_dislike where user_id='" . $user_id . "' and status=1";
		$res = $this->conn->query($sql);
		$user = $res->fetch_assoc();
		$parking_id = $user['parking_id'];
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
				return false;
				}
			}
		  else
			{
			if ($this->conn->affected_rows > 0)
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
			$sql1 = "SELECT id, ( 3959 * acos( cos( radians('" . $lat . "') ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians('" . $long . "') ) + sin( radians('" . $lat . "') ) * sin( radians( latitude ) ) ) ) AS distance FROM parking_lot_master WHERE STATUS =1 HAVING distance < " . $miles . " ORDER BY distance LIMIT 0 , 20";
		$res1 = $this->conn->query($sql1);
        $i=0;
		$data=array();
		while($user=$res1->fetch_assoc()){
		  $data[$i]=$user['id'];
		  $sql2 = "select * from like_dislike where parking_id = '".$data[$i]."'";
		  $res2 = $this->conn->query($sql2);
		  $data1=array();
		while($user=$res2->fetch_assoc()){
		$data1[$i]=$user['status'];
        print_r(array_merge($data,$data1));
		}
    	  $i++;
		}
		die();
		//print_r($data);die();
		$sql = "SELECT *, ( 3959 * acos( cos( radians('" . $lat . "') ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians('" . $long . "') ) + sin( radians('" . $lat . "') ) * sin( radians( latitude ) ) ) ) AS distance FROM parking_lot_master WHERE STATUS =1 HAVING distance < " . $miles . " ORDER BY distance LIMIT 0 , 20";
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

	/**
	 * Check user is existed or not
	 */
	public

	function isUserExisted($email)
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


 