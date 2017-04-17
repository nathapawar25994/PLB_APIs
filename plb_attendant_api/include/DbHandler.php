<?php

class DbHandler {

    private $conn;

    function __construct() {
        require_once dirname(__FILE__) . '/DbConnect.php';
        // opening db connection
        $db = new DbConnect();
        $this->conn = $db->connect();
    }

    

    

public function get_User_By_EmailAndPassword($email, $password) {
         $email=$email;
        $res = $this->conn->query("SELECT * FROM attendent_master WHERE email='".$email."'");
       
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

    public function requested_parking($parking_id) {
         
        $result = $this->conn->query("SELECT * FROM reservlot WHERE parking_id='".$parking_id."' and status='0'");
       
        if(mysqli_num_rows($result) > 0){
     
        $data=array();
        $i=0;
        while($user=$result->fetch_assoc()){
                $data[$i]['reserve_id']=$user['reserve_id'];
                $data[$i]['parking_id']=$user['parking_id'];      
                $data[$i]['user_id']=$user['user_id'];
                $data[$i]['from_time']=$user['from_time'];
                $data[$i]['to_time']=$user['to_time'];
                $data[$i]['lot_no']=$user['lot_no'];
                $data[$i]['reserv_date']=$user['reserv_date'];
                $data[$i]['like_dislike']=$user['like_dislike'];
                $data[$i]['status']=$user['status'];
                $i++;
        }
        return $data;
        
    } else {
            return NULL;
        }
    }
    
     public function attendant_list($attendant_id) {
         
        $result = $this->conn->query("SELECT parking_id FROM attendent_master
 WHERE id='".$attendant_id."' ");

         
        if(mysqli_num_rows($result) > 0){
     
        $data=array();
        $arr=array();
        $temp=array();
        $i=0;
        while($user=$result->fetch_assoc()){
                $arr=explode(',',$user['parking_id']);  
              }
              if(count($arr==1)){
        foreach ($arr as $value) {
            $res = $this->conn->query("SELECT id,lot_name,address FROM parking_lot_master
 WHERE id='".$value."' ");
            while($us=$res->fetch_assoc()){
                $data[$i]['id']=$us['id'];
                $data[$i]['lot_name']=$us['lot_name']; 
                $data[$i]['address']=$us['address'];    
        }
        $i++;
        }
      }else{

            foreach ($arr as $value) {
            $res = $this->conn->query("SELECT id,lot_name,address FROM parking_lot_master
 WHERE id='".$value."' ");
            while($us=$res->fetch_assoc()){
                $data['id']=$us['id'];
                $data['lot_name']=$us['lot_name']; 
                $data['address']=$us['address'];    
        }
        
        }

      }
        return $data;
                
    } else {
            return NULL;
        }
    }
    

    public function confirm_parking($parking_id, $user_id,$reserve_id) {
         
         $query="update reservlot set status=1  where parking_id='".$parking_id."' and user_id='".$user_id."' and reserve_id='".$reserve_id."' ";
        $res = $this->conn->query($query);
       
        if ($this->conn->affected_rows) {
            return $res;
        } else {
            return NULL;
        }
    }
    

    public function cancel_parking($parking_id, $user_id,$reserve_id) {
         
         $query="update reservlot set status=2  where parking_id='".$parking_id."' and user_id='".$user_id."' and reserve_id='".$reserve_id."' ";
        $res = $this->conn->query($query);
       
        if ($this->conn->affected_rows) {
            return $res;
        } else {
            return NULL;
        }
    }

}

?>
