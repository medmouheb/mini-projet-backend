<?php
class Location{
  
    // database connection and table name
    private $conn;
    private $table_name = "location";
  
    // object properties
    public $locationID;
    public $state;
    public $address;
    public $mapCorrdination;
    public $locationImg;
  
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
    function create(){
  
        // query to insert record
        $query = "INSERT INTO 
                    " . $this->table_name . "
                    (`state`,`address`,`mapCorrdination`,`locationImg`)
                    VALUES (?,?,?,?)                    
                    ";
      
        // prepare query
        $stmt = $this->conn->prepare($query);
      
        // sanitize
        $this->state=htmlspecialchars(strip_tags($this->state));
        $this->address=htmlspecialchars(strip_tags($this->address));
        $this->mapCorrdination=htmlspecialchars(strip_tags($this->mapCorrdination));
        $this->locationImg=htmlspecialchars(strip_tags($this->locationImg));
        
        
        
        // bind values
        $stmt->bindParam(1, $this->state);
        $stmt->bindParam(2, $this->address);
        $stmt->bindParam(3, $this->mapCorrdination);
        $stmt->bindParam(4, $this->locationImg);
        

      
        // execute query
        if($stmt->execute()){
            

            return true;
        }
        

        return false;
          
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

    function update(){
        // update query
        $query = "UPDATE ".$this->table_name." 
                    SET 
                    `state`= :state,
                    `address`= :address,
                    `mapCorrdination`= :mapCorrdination ,
                    `locationImg`= :locationImg 
                    WHERE `locationID`= :locationID
                    ";
      
        // prepare query statement
        $stmt = $this->conn->prepare($query);
      
        // sanitize
        
        $this->locationID=htmlspecialchars(strip_tags($this->locationID));
        $this->address=htmlspecialchars(strip_tags($this->address));
        $this->mapCorrdination=htmlspecialchars(strip_tags($this->mapCorrdination));
        $this->locationImg=htmlspecialchars(strip_tags($this->locationImg));
        $this->state=htmlspecialchars(strip_tags($this->state));
      
        // bind new values
        
        
        $stmt->bindParam(":locationID", $this->locationID);
        $stmt->bindParam(":mapCorrdination", $this->mapCorrdination);
        $stmt->bindParam(":locationImg", $this->locationImg);
        $stmt->bindParam(":state", $this->state);
        $stmt->bindParam(":address", $this->address);
      
        // execute the query
        if($stmt->execute()){
            return true;
        }
      
        return false;
    }

    function delete(){
  
        // delete query
        $query = "DELETE FROM ".$this->table_name." WHERE locationID = ?";
      
        // prepare query
        $stmt = $this->conn->prepare($query);
      
        // sanitize
        $this->locationID=htmlspecialchars(strip_tags($this->locationID));
      
        // bind locationID of record to delete
        $stmt->bindParam(1, $this->locationID);
      
        // execute query
        if($stmt->execute()){
            return true;
        }
      
        return false;
    }
}
?>