<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
  
// include database and object files
include_once '../../config/database.php';
include_once '../../objects/carmodale.php';
  
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
  
// initialize object
$product = new CarModale($db);
  
// query carmodale
$stmt = $product->read();
$num = $stmt->rowCount();
  
// check if more than 0 record found
if($num>0){
  
    // carmodale array
    $carmodale_arr=array();
    $carmodale_arr["records"]=array();
  
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
  
        $product_item=array(
            "carModaleID" => $carModaleID,
            "carName" => $carName,
            "carFamily" => $carFamily,
            "carPrice" => $carPrice,
            "nombreOfPlaces" => $nombreOfPlaces,
            "img1" => $img1,
            "img2" => $img2,
            "img3" => $img3,
            "img4" => $img4,
            "nombreOfCylindres" => $nombreOfCylindres,
            "energie" => $energie,
            "consomtion" => $consomtion,
            "boite" => $boite
            
        );
  
        array_push($carmodale_arr["records"], $product_item);
    }
  
    // set response code - 200 OK
    http_response_code(200);
  
    // show carmodale data in json format
    echo json_encode($carmodale_arr);
}
  
// no carmodale found will be here