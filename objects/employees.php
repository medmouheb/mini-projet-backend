<?php
class Employees{
  
    // database connection and table name
    private $conn;
    private $table_name = "employees";
  
    // object properties
    public $employeeID;
    public $fistname;
    public $lastname;
    public $email;
    public $password;
    public $tel;
    public $address;
    public $role;
    public $locationID;
  
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    function read(){
  
        // select all query
        $query = "SELECT * FROM " . $this->table_name ;
      
        // prepare query statement
        $stmt = $this->conn->prepare($query);
      
        // execute query
        $stmt->execute();
      
        return $stmt;
    }

    function create(){
 
        // insert query
        $query = "INSERT INTO " . $this->table_name . "
                SET
                    fistname = :fistname,
                    lastname = :lastname,
                    email = :email,
                    password = :password,
                    tel = :tel,
                    address = :address,
                    role = :role,
                    locationID = :locationID
                    ";
     
        // prepare the query
        $stmt = $this->conn->prepare($query);
     
        // sanitize
        $this->fistname=htmlspecialchars(strip_tags($this->fistname));
        $this->lastname=htmlspecialchars(strip_tags($this->lastname));
        $this->email=htmlspecialchars(strip_tags($this->email));
        $this->password=htmlspecialchars(strip_tags($this->password));
        $this->tel=htmlspecialchars(strip_tags($this->tel));
        $this->address=htmlspecialchars(strip_tags($this->address));
        $this->role=htmlspecialchars(strip_tags($this->role));
        $this->locationID=htmlspecialchars(strip_tags($this->locationID));

        // bind the values
        $stmt->bindParam(':fistname', $this->fistname);
        $stmt->bindParam(':lastname', $this->lastname);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':tel', $this->tel);
        $stmt->bindParam(':address', $this->address);
        $stmt->bindParam(':role', $this->role);
        $stmt->bindParam(':locationID', $this->locationID);

        // hash the password before saving to database
        $password_hash = password_hash($this->password, PASSWORD_BCRYPT);
        $stmt->bindParam(':password', $password_hash);
     
        // execute the query, also check if query was successful
        if($stmt->execute()){
            return true;
        }
     
        return false;
    }

    function emailExists(){
        // query to check if email exists
        $query = "SELECT employeeID, fistname, lastname, password, tel, address, role, locationID
                FROM " . $this->table_name . "
                WHERE email = ?
                LIMIT 0,1";
     
        // prepare the query
        $stmt = $this->conn->prepare( $query );
     
        // sanitize
        $this->email=htmlspecialchars(strip_tags($this->email));
     
        // bind given email value
        $stmt->bindParam(1, $this->email);
     
        // execute the query
        $stmt->execute();
     
        // get number of rows
        $num = $stmt->rowCount();
        // if email exists, assign values to object properties for easy access and use for php sessions
        if($num>0){
     
            // get record details / values
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
     
            // assign values to object properties
            $this->employeeID = $row['employeeID'];
            $this->fistname = $row['fistname'];
            $this->lastname = $row['lastname'];
            $this->password = $row['password'];
            $this->tel = $row['tel'];
            $this->address = $row['address'];
            $this->role = $row['role'];
            $this->locationID = $row['locationID'];
            // return true because email exists in the database
             
            return true;
        }
     
        // return false if email does not exist in the database
        return false;
    }

    function delete(){
  
        // delete query
        $query = "DELETE FROM ".$this->table_name." WHERE employeeID = ?";
      
        // prepare query
        $stmt = $this->conn->prepare($query);
      
        // sanitize
        $this->employeeID=htmlspecialchars(strip_tags($this->employeeID));
      
        // bind employeeID of record to delete
        $stmt->bindParam(1, $this->employeeID);
      
        // execute query
        if($stmt->execute()){
            return true;
        }
      
        return false;
    }
}
?>