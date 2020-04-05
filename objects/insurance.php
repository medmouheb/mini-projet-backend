<?php
class Insurance{
  
    // database connection and table name
    private $conn;
    private $table_name = "insurance";
  
    // object properties
    public $insuranceID;
    public $insuranceName;
    public $insuranceDescription;
    public $insuranceDuantion;
    public $insurancePrice;
  
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
    function create(){
  
        // query to insert record
        $query = "INSERT INTO 
                    " . $this->table_name . "
                    (`insuranceName`,`insuranceDescription`,`insuranceDuantion`,`insurancePrice`)
                    VALUES (?,?,?,?)                    
                    ";
      
        // prepare query
        $stmt = $this->conn->prepare($query);
      
        // sanitize
        $this->insuranceName=htmlspecialchars(strip_tags($this->insuranceName));
        $this->insuranceDescription=htmlspecialchars(strip_tags($this->insuranceDescription));
        $this->insuranceDuantion=htmlspecialchars(strip_tags($this->insuranceDuantion));
        $this->insurancePrice=htmlspecialchars(strip_tags($this->insurancePrice));
        
        
        
        // bind values
        $stmt->bindParam(1, $this->insuranceName);
        $stmt->bindParam(2, $this->insuranceDescription);
        $stmt->bindParam(3, $this->insuranceDuantion);
        $stmt->bindParam(4, $this->insurancePrice);
        

      
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
                    `insuranceName`= :insuranceName,
                    `insuranceDescription`= :insuranceDescription,
                    `insuranceDuantion`= :insuranceDuantion ,
                    `insurancePrice`= :insurancePrice 
                    WHERE `insuranceID`= :insuranceID
                    ";
      
        // prepare query statement
        $stmt = $this->conn->prepare($query);
      
        // sanitize
        
        $this->insuranceID=htmlspecialchars(strip_tags($this->insuranceID));
        $this->insuranceDescription=htmlspecialchars(strip_tags($this->insuranceDescription));
        $this->insuranceDuantion=htmlspecialchars(strip_tags($this->insuranceDuantion));
        $this->insurancePrice=htmlspecialchars(strip_tags($this->insurancePrice));
        $this->insuranceName=htmlspecialchars(strip_tags($this->insuranceName));
      
        // bind new values
        
        
        $stmt->bindParam(":insuranceID", $this->insuranceID);
        $stmt->bindParam(":insuranceDuantion", $this->insuranceDuantion);
        $stmt->bindParam(":insurancePrice", $this->insurancePrice);
        $stmt->bindParam(":insuranceName", $this->insuranceName);
        $stmt->bindParam(":insuranceDescription", $this->insuranceDescription);
      
        // execute the query
        if($stmt->execute()){
            return true;
        }
      
        return false;
    }

    function delete(){
  
        // delete query
        $query = "DELETE FROM ".$this->table_name." WHERE insuranceID = ?";
      
        // prepare query
        $stmt = $this->conn->prepare($query);
      
        // sanitize
        $this->insuranceID=htmlspecialchars(strip_tags($this->insuranceID));
      
        // bind insuranceID of record to delete
        $stmt->bindParam(1, $this->insuranceID);
      
        // execute query
        if($stmt->execute()){
            return true;
        }
      
        return false;
    }
}
?>