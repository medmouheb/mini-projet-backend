<?php
class Constraint
{

    // database connection and table name
    public $conn;
    private $table_name = 'constraint';

    // object properties
    public $constraintID;
    public $carID;
    public $totalPrice;
    public $rentedfrom;
    public $rentedto;
    public $promoID;
    public $insuranceID;
    public $locationID;
    public $clientID;


    // constructor with $db as database connection
    public function __construct($db)
    {
        $this->conn = $db;
    }

    function create()
    {

        // query to insert record
        $query = "INSERT INTO `constraint`( `carID`, `totalPrice`, `promoID`, `insuranceID`, `locationID`, `clientID`) VALUES (?,?,?,?,?,?)";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->carID = htmlspecialchars(strip_tags($this->carID));
        $this->totalPrice = htmlspecialchars(strip_tags($this->totalPrice));
        $this->promoID = htmlspecialchars(strip_tags($this->promoID));
        $this->insuranceID = htmlspecialchars(strip_tags($this->insuranceID));
        $this->locationID = htmlspecialchars(strip_tags($this->locationID));
        $this->clientID = htmlspecialchars(strip_tags($this->clientID));


        echo json_encode($stmt);
        // bind values
        $stmt->bindParam(1, $this->carID);
        $stmt->bindParam(2, $this->totalPrice);
        $stmt->bindParam(3, $this->promoID);
        $stmt->bindParam(4, $this->insuranceID);
        $stmt->bindParam(5, $this->locationID);
        $stmt->bindParam(6, $this->clientID);



        // execute query
        if ($stmt->execute()) {

            return true;
        }
        echo json_encode($stmt);

        return false;
    }
    function read()
    {

        // select all query
        $query = "SELECT * FROM 
        `constraint` as co , 
        carmodale as cm,
        car as ca, 
        insurance as i, 
        location as l, 
        promo as p 
        where co.carID=ca.carID 
        and ca.carModaleID=cm.carModaleID
        and co.insuranceID=i.insuranceID 
        and co.locationID=l.locationID 
        and co.promoID=p.promoID";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }
    function search($locationSearch, $carSearch, $fromSearch, $toSearch)
    {
        echo $toSearch;
        // select all query
        $query = "
        SELECT * FROM 
        `constraint` as co , 
        carmodale as cm,
        car as ca, 
        insurance as i, 
        location as l, 
        promo as p 
        where
        co.rentedfrom < ".$fromSearch." and co.rentedto < ".$fromSearch."
        and co.locationID=? and co.carID=?
        and co.carID=ca.carID 
        and ca.carModaleID=cm.carModaleID
        and co.insuranceID=i.insuranceID 
        and co.locationID=l.locationID 
        and co.promoID=p.promoID
        union
        SELECT * FROM 
        `constraint` as co , 
        carmodale as cm,
        car as ca, 
        insurance as i, 
        location as l, 
        promo as p 
        where
        co.rentedfrom > ".$toSearch." and co.rentedto > ".$toSearch."
        and co.locationID=? and co.carID=?
        and co.carID=ca.carID 
        and ca.carModaleID=cm.carModaleID
        and co.insuranceID=i.insuranceID 
        and co.locationID=l.locationID 
        and co.promoID=p.promoID
        
        ";

        // prepare query statement
        $stmt = $this->conn->prepare($query);
        // $stmt->bindParam(1, $fromSearch);
        // $stmt->bindParam(2, $fromSearch);
        // $stmt->bindParam(5, $toSearch);
        // $stmt->bindParam(6, $toSearch);

        $stmt->bindParam(1, $locationSearch);
        $stmt->bindParam(3, $locationSearch);
        $stmt->bindParam(2, $carSearch);
        $stmt->bindParam(4, $carSearch);
        // execute query
        $stmt->execute();

        return $stmt;
    }

    function update(){
        // update query
        $query = "UPDATE `constraint`
                    SET 
                    `carID`= :carID,
                    `totalPrice`= :totalPrice,
                    `rentedfrom`= :rentedfrom,
                    `rentedto`= :rentedto,
                    `promoID`= :promoID,
                    `insuranceID`= :insuranceID,
                    `locationID`= :locationID,
                    `clientID`= :clientID
                    WHERE `constraintID`= :constraintID
                    ";
      
        // prepare query statement
        $stmt = $this->conn->prepare($query);
      
        // sanitize
        
        $this->constraintID=htmlspecialchars(strip_tags($this->constraintID));
        $this->carID=htmlspecialchars(strip_tags($this->carID));
        $this->totalPrice=htmlspecialchars(strip_tags($this->totalPrice));
        $this->rentedfrom=htmlspecialchars(strip_tags($this->rentedfrom));
        $this->rentedto=htmlspecialchars(strip_tags($this->rentedto));
        $this->promoID=htmlspecialchars(strip_tags($this->promoID));
        $this->insuranceID=htmlspecialchars(strip_tags($this->insuranceID));
        $this->locationID=htmlspecialchars(strip_tags($this->locationID));
        $this->clientID=htmlspecialchars(strip_tags($this->clientID));

      
        // bind new values
        
        
        $stmt->bindParam(":constraintID", $this->constraintID);
        $stmt->bindParam(":carID", $this->carID);
        $stmt->bindParam(":totalPrice", $this->totalPrice);
        $stmt->bindParam(":rentedfrom", $this->rentedfrom);
        $stmt->bindParam(":rentedto", $this->rentedto);
        $stmt->bindParam(":promoID", $this->promoID);
        $stmt->bindParam(":insuranceID", $this->insuranceID);
        $stmt->bindParam(":locationID", $this->locationID);
        $stmt->bindParam(":clientID", $this->clientID);
        
      
        // execute the query
        if($stmt->execute()){
            return true;
        }
      
        return false;
    }

    function delete(){
  
        // delete query
        $query = "DELETE FROM `constraint` WHERE constraintID = ?";
      
        // prepare query
        $stmt = $this->conn->prepare($query);
      
        // sanitize
        $this->constraintID=htmlspecialchars(strip_tags($this->constraintID));
      
        // bind constraintID of record to delete
        $stmt->bindParam(1, $this->constraintID);
      
        // execute query
        if($stmt->execute()){
            return true;
        }
      
        return false;
    }
}
