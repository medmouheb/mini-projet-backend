<?php
class Promo{
  
    // database connection and table name
    private $conn;
    private $table_name = "promo";
  
    // object properties
    public $promoID;
    public $promoName;
    public $promoDuration;
    public $discountPercent;
    public $promoImg;
  
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    function create(){
  
        // query to insert record
        $query = "INSERT INTO 
                    " . $this->table_name . "
                    (`promoName`,`promoDuration`,`discountPercent`,`promoImg`)
                    VALUES (?,?,?,?)                    
                    ";
      
        // prepare query
        $stmt = $this->conn->prepare($query);
      
        // sanitize
        $this->promoName=htmlspecialchars(strip_tags($this->promoName));
        $this->promoDuration=htmlspecialchars(strip_tags($this->promoDuration));
        $this->discountPercent=htmlspecialchars(strip_tags($this->discountPercent));
        $this->promoImg=htmlspecialchars(strip_tags($this->promoImg));
        
        
        
        // bind values
        $stmt->bindParam(1, $this->promoName);
        $stmt->bindParam(2, $this->promoDuration);
        $stmt->bindParam(3, $this->discountPercent);
        $stmt->bindParam(4, $this->promoImg);
        

      
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
                    `promoName`= :promoName,
                    `promoDuration`= :promoDuration,
                    `discountPercent`= :discountPercent ,
                    `promoImg`= :promoImg 
                    WHERE `promoID`= :promoID
                    ";
      
        // prepare query statement
        $stmt = $this->conn->prepare($query);
      
        // sanitize
        
        $this->promoID=htmlspecialchars(strip_tags($this->promoID));
        $this->promoDuration=htmlspecialchars(strip_tags($this->promoDuration));
        $this->discountPercent=htmlspecialchars(strip_tags($this->discountPercent));
        $this->promoImg=htmlspecialchars(strip_tags($this->promoImg));
        $this->promoName=htmlspecialchars(strip_tags($this->promoName));
      
        // bind new values
        
        
        $stmt->bindParam(":promoID", $this->promoID);
        $stmt->bindParam(":discountPercent", $this->discountPercent);
        $stmt->bindParam(":promoImg", $this->promoImg);
        $stmt->bindParam(":promoName", $this->promoName);
        $stmt->bindParam(":promoDuration", $this->promoDuration);
      
        // execute the query
        if($stmt->execute()){
            return true;
        }
      
        return false;
    }


    function delete(){
  
        // delete query
        $query = "DELETE FROM ".$this->table_name." WHERE promoID = ?";
      
        // prepare query
        $stmt = $this->conn->prepare($query);
      
        // sanitize
        $this->promoID=htmlspecialchars(strip_tags($this->promoID));
      
        // bind promoID of record to delete
        $stmt->bindParam(1, $this->promoID);
      
        // execute query
        if($stmt->execute()){
            return true;
        }
      
        return false;
    }
}
?>