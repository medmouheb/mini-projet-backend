<?php
class Car{
  
    // database connection and table name
    public $conn;
    private $table_name = "car";
  
    // object properties
    public $carID;
    public $carModaleID;
    public $pricePerDay;
    public $color;
  
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    function create(){
  
        // query to insert record
        $query = "INSERT INTO 
                    " . $this->table_name . "
                SET
                    carModaleID=:carModaleID,
                     pricePerDay=:pricePerDay, 
                     color=:color";
      
        // prepare query
        $stmt = $this->conn->prepare($query);
      
        // sanitize
        $this->carModaleID=htmlspecialchars(strip_tags($this->carModaleID));
        $this->pricePerDay=htmlspecialchars(strip_tags($this->pricePerDay));
        $this->color=htmlspecialchars(strip_tags($this->color));
        
        
        // bind values
        $stmt->bindParam(":carModaleID", $this->carModaleID);
        $stmt->bindParam(":pricePerDay", $this->pricePerDay);
        $stmt->bindParam(":color", $this->color);

      
        // execute query
        if($stmt->execute()){
            

            return true;
        }
        

        return false;
          
    }
    function read(){
  
        // select all query
        $query = "SELECT * FROM " . $this->table_name." as c1 , carmodale as c2 where c1.carModaleID=c2.carModaleID " ;
      
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
                    `color`= :color,
                    `carModaleID`= :carModaleID,
                    `pricePerDay`= :pricePerDay 
                    WHERE `carID`= :carID
                    ";
      
        // prepare query statement
        $stmt = $this->conn->prepare($query);
      
        // sanitize
        
        $this->carID=htmlspecialchars(strip_tags($this->carID));
        $this->carModaleID=htmlspecialchars(strip_tags($this->carModaleID));
        $this->pricePerDay=htmlspecialchars(strip_tags($this->pricePerDay));
        $this->color=htmlspecialchars(strip_tags($this->color));
      
        // bind new values
        
        
        $stmt->bindParam(":carID", $this->carID);
        $stmt->bindParam(":pricePerDay", $this->pricePerDay);
        $stmt->bindParam(":color", $this->color);
        $stmt->bindParam(":carModaleID", $this->carModaleID);
      
        // execute the query
        if($stmt->execute()){
            return true;
        }
      
        return false;
    }

    function delete(){
  
        // delete query
        $query = "DELETE FROM " . $this->table_name . " WHERE carID = ?";
      
        // prepare query
        $stmt = $this->conn->prepare($query);
      
        // sanitize
        $this->carID=htmlspecialchars(strip_tags($this->carID));
      
        // bind carID of record to delete
        $stmt->bindParam(1, $this->carID);
      
        // execute query
        if($stmt->execute()){
            return true;
        }
      
        return false;
    }
}
?>