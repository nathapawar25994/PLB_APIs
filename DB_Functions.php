<?php
 

class DB_Functions {
 
    private $conn;
 
    // constructor
    function __construct() {
        require_once 'DB_Connect.php';
        // connecting to database
        $db = new Db_Connect();
        $this->conn = $db->connect();
    }
 
    // destructor
    function __destruct() {
         
    }
 
    /**
     * Storing new user
     * returns user details
     */
    public function storeUser($full_name, $email,$mobile_no,$password,$bike_numbers) {
       
        
         
        $query="insert into users(full_name,email_id,mobile_no,password,bike_numbers)values('".$full_name."','".$email."','".$mobile_no."','".md5($password)."','".$bike_numbers."')";
        $result=$this->conn->query($query);
       
        if ($result) {
            
           $sql="SELECT * from users where email_id='".$email."'";
          $res=$this->conn->query($sql);
          $user=$res->fetch_assoc();

           return $user;
        } else {
            return false;
        }
    }
	public function reservLot($from_time, $to_time,$lot_no,$user_id,$parking_id,$reserv_date) {
       
        
         $status=0;
        $query="insert into reservlot(user_id,parking_id,from_time,to_time,lot_no,reserv_date,status)values('".$user_id."','".$parking_id."','".$from_time."','".$to_time."','".$lot_no."','".$reserv_date."','".$status."')";
        $result=$this->conn->query($query);
       
        if ($result) {
           return $result;
        } else {
            return false;
        }
    }
	
	public function updatereservLot($from_time, $to_time,$lot_no,$user_id,$parking_id,$res_id,$reserv_date) {
       
        
         
        $query="update reservlot set user_id='".$user_id."',parking_id='".$parking_id."',from_time='".$from_time."',to_time='".$to_time."',lot_no='".$lot_no."',reserv_date='".$reserv_date."' where reserve_id='".$res_id."' ";
        $result=$this->conn->query($query);
       
        if ($result) {
           return $result;
        } else {
            return false;
        }
    }
	
	public function getreservationlist($user_id,$parking_id) {
		$sql="select rl.*,plm.* from reservlot rl,parking_lot_master plm WHERE rl.parking_id=plm.id and rl.user_id='".$user_id."' and rl.parking_id='".$parking_id."'";
          $res=$this->conn->query($sql);
          
        if ($res) {
           return $res;
        } else {
            return false;
        }
    }
	
	public function countsoflots($parking_id) {
		$sql="select rl.lot_no,rl.status,plm.parking_owner,plm.lot_name,plm.two_wheeler,plm.car_parking,plm.heavy_vehicles from reservlot rl,parking_lot_master plm WHERE rl.parking_id=plm.id and rl.parking_id='".$parking_id."' and plm.id='".$parking_id."' and plm.status=1";
          $res=$this->conn->query($sql);
          
        if ($res) {
           return $res;
        } else {
            return false;
        }
    }
	public function getreservedlots($parking_id,$date) {
		$sql="SELECT reservlot.lot_no FROM `parking_lot_master`,reservlot where parking_lot_master.id=reservlot.parking_id and reservlot.parking_id='".$parking_id."' and reserv_date='".$date."' and parking_lot_master.status=1 and reservlot.status=1";
          $res=$this->conn->query($sql);
          
        if ($res) {
           return $res;
        } else {
            return false;
        }
    }
	public function updatelikedislike($user_id,$parking_id,$res_id) {
       
        
         
        $query="update reservlot set like_dislike=1 where reserve_id='".$res_id."' and user_id='".$user_id."' and parking_id='".$parking_id."'";
        $result=$this->conn->query($query);
       
        if ($result) {
           return $result;
        } else {
            return false;
        }
    }
	
	public function update_miles($user_id,$miles) {
       
        
         
        $query="update users set miles='".$miles."' where user_id='".$user_id."'";
        $result=$this->conn->query($query);
       
        if ($result) {
           return $result;
        } else {
            return false;
        }
    }
	public function update_bike_numbers($user_id,$bike_numbers) {
       
        
         
        $query="update users set bike_numbers='".$bike_numbers."' where user_id='".$user_id."'";
        $result=$this->conn->query($query);
       
        if ($result) {
           return $result;
        } else {
            return false;
        }
    }
	public function findlocation($long,$lat,$user_id) {
		
	
		$result = $this->conn->query("SELECT miles FROM users
 WHERE user_id='".$user_id."' ");

		
		while($user=$result->fetch_assoc()){
			
			$miles=$user['miles'];
		}
		
		$sql="SELECT *, ( 3959 * acos( cos( radians('".$lat."') ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians('".$long."') ) + sin( radians('".$lat."') ) * sin( radians( latitude ) ) ) ) AS distance FROM parking_lot_master WHERE STATUS =1 HAVING distance < ".$miles." ORDER BY distance LIMIT 0 , 20";
          $res=$this->conn->query($sql);
          
        if ($res) {
           return $res;
        } else {
            return false;
        }
    }
 
    /**
     * Get user by email and password
     */
    public function getUserByEmailAndPassword($email, $password) {
         $email=$email;
        $res = $this->conn->query("SELECT * FROM users WHERE email_id ='".$email."'");
       
        if ($res) {
            $user = $res->fetch_assoc();
            $encrypted_password = $user['password'];
            // check for password equality
            $org_pass=md5($password);
            if ($encrypted_password == $org_pass) {
                // user authentication details are correct
                return $user;
            }
        } else {
            return NULL;
        }
    }
 
    /**
     * Check user is existed or not
     */
    public function isUserExisted($email) {
        $stmt = $this->conn->prepare("SELECT email_id from users WHERE email_id = ?");
 
        $stmt->bind_param("s", $email);
 
        $stmt->execute();
 
        $stmt->store_result();
 
        if ($stmt->num_rows > 0) {
            // user existed 
            $stmt->close();
            return true;
        } else {
            // user not existed
            $stmt->close();
            return false;
        }
    }
 
   
}
 
?>