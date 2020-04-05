<?php
class CarModale{
  
    // database connection and table name
    private $conn;
    private $table_name = "carmodale";
  
    // object properties
    public $carModaleID;
    public $carName;
    public $carFamily;
    public $carPrice;
    public $nombreOfPlaces;
    public $nombreOfCylindres;
    public $img1;
    public $img2;
    public $img3;
    public $img4;
    public $energie;
    public $consomtion;
    public $boite;
  
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
    function create(){
  
        // query to insert record
        $query = "INSERT INTO 
                    " . $this->table_name . "
                SET
                carName=:carName,carFamily=:carFamily,carPrice=:carPrice,nombreOfPlaces=:nombreOfPlaces,nombreOfCylindres=:nombreOfCylindres,img1=:img1,img2=:img2,img3=:img3,img4=:img4,energie=:energie,consomtion=:consomtion,boite=:boite";
      
        // prepare query
        $stmt = $this->conn->prepare($query);
      
        // sanitize
        
        $this->carName=htmlspecialchars(strip_tags($this->carName));
        $this->carFamily=htmlspecialchars(strip_tags($this->carFamily));
        $this->carPrice=htmlspecialchars(strip_tags($this->carPrice));
        $this->nombreOfPlaces=htmlspecialchars(strip_tags($this->nombreOfPlaces));
        $this->nombreOfCylindres=htmlspecialchars(strip_tags($this->nombreOfCylindres));
        $this->img1=htmlspecialchars(strip_tags($this->img1));
        $this->img2=htmlspecialchars(strip_tags($this->img2));
        $this->img3=htmlspecialchars(strip_tags($this->img3));
        $this->img4=htmlspecialchars(strip_tags($this->img4));
        $this->consomtion=htmlspecialchars(strip_tags($this->consomtion));
        $this->boite=htmlspecialchars(strip_tags($this->boite));
        $this->energie=htmlspecialchars(strip_tags($this->energie));
      
        // bind values
    
        $stmt->bindParam(":carName", $this->carName);
        $stmt->bindParam(":carFamily", $this->carFamily);
        $stmt->bindParam(":carPrice", $this->carPrice);
        $stmt->bindParam(":nombreOfPlaces", $this->nombreOfPlaces);
        $stmt->bindParam(":nombreOfCylindres", $this->nombreOfCylindres);
        $stmt->bindParam(":img1", $this->img1);
        $stmt->bindParam(":img2", $this->img2);
        $stmt->bindParam(":img3", $this->img3);
        $stmt->bindParam(":img4", $this->img4);
        $stmt->bindParam(":consomtion", $this->consomtion);
        $stmt->bindParam(":boite", $this->boite);
        $stmt->bindParam(":energie", $this->energie);
 
 
      
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
        $query = "UPDATE
                    " . $this->table_name . "
                SET
                carName = :carName,
                carFamily = :carFamily,
                carPrice = :carPrice,
                nombreOfPlaces = :nombreOfPlaces,
                nombreOfCylindres = :nombreOfCylindres,
                img1 = :img1,
                img2 = :img2,
                img3 = :img3,
                img4 = :img4,
                energie = :energie,
                consomtion = :consomtion,
                boite = :boite
                    
                WHERE
                    carModaleID = :carModaleID";
      
        // prepare query statement
        $stmt = $this->conn->prepare($query);
      
        // sanitize
        
        $this->carModaleID=htmlspecialchars(strip_tags($this->carModaleID));
        $this->carName=htmlspecialchars(strip_tags($this->carName));
        $this->carFamily=htmlspecialchars(strip_tags($this->carFamily));
        $this->carPrice=htmlspecialchars(strip_tags($this->carPrice));
        $this->nombreOfPlaces=htmlspecialchars(strip_tags($this->nombreOfPlaces));
        $this->nombreOfCylindres=htmlspecialchars(strip_tags($this->nombreOfCylindres));
        $this->img1=htmlspecialchars(strip_tags($this->img1));
        $this->img2=htmlspecialchars(strip_tags($this->img2));
        $this->img3=htmlspecialchars(strip_tags($this->img3));
        $this->img4=htmlspecialchars(strip_tags($this->img4));
        $this->energie=htmlspecialchars(strip_tags($this->energie));
        $this->consomtion=htmlspecialchars(strip_tags($this->consomtion));
        $this->boite=htmlspecialchars(strip_tags($this->boite));

        // bind new values
        
        $stmt->bindParam(':carModaleID', $this->carModaleID);
        $stmt->bindParam(':carName', $this->carName);
        $stmt->bindParam(':carFamily', $this->carFamily);
        $stmt->bindParam(':carPrice', $this->carPrice);
        $stmt->bindParam(':nombreOfPlaces', $this->nombreOfPlaces);
        $stmt->bindParam(':nombreOfCylindres', $this->nombreOfCylindres);
        $stmt->bindParam(':img1', $this->img1);
        $stmt->bindParam(':img2', $this->img2);
        $stmt->bindParam(':img3', $this->img3);
        $stmt->bindParam(':img4', $this->img4);
        $stmt->bindParam(':energie', $this->energie);
        $stmt->bindParam(':consomtion', $this->consomtion);
        $stmt->bindParam(':boite', $this->boite);
      
        // execute the query
        if($stmt->execute()){
            return true;
        }
      
        return false;
    }

    // delete the product
function delete(){
  
    // delete query
    $query = "DELETE FROM " . $this->table_name . " WHERE carModaleID = ?";
  
    // prepare query
    $stmt = $this->conn->prepare($query);
  
    // sanitize
    $this->carModaleID=htmlspecialchars(strip_tags($this->carModaleID));
  
    // bind carModaleID of record to delete
    $stmt->bindParam(1, $this->carModaleID);
  
    // execute query
    if($stmt->execute()){
        return true;
    }
  
    return false;
}
}
?>