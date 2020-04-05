<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
  
// include database and object files
include_once '../../config/database.php';
include_once '../../objects/constraint.php';
  
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
  
// initialize object
$product = new Constraint($db);
  
// get l
$locationSearch=isset($_GET["locationSearch"]) ? $_GET["locationSearch"] : "";
$carSearch=isset($_GET["carSearch"]) ? $_GET["carSearch"] : "";
$fromSearch=isset($_GET["fromSearch"]) ? $_GET["fromSearch"] : "";
$toSearch=isset($_GET["toSearch"]) ? $_GET["toSearch"] : ""; 

// query products
$stmt = $product->search($locationSearch,$carSearch,$fromSearch,$toSearch);
$num = $stmt->rowCount();
  
// check if more than 0 record found
if($num>0){
  
    // products array
    $products_arr=array();
    $products_arr["records"]=array();
  
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
  
        $product_item=array(
            "constraintID" => $constraintID,
            "totalPrice" => $totalPrice,
            "rentedfrom" => $rentedfrom,
            "rentedto" => $rentedto,
            "carID" => $carID,
            "pricePerDay" => $pricePerDay,
            "color" => $color,
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
            "boite" => $boite,
            "insuranceID" => $insuranceID,
            "insuranceName" => $insuranceName,
            "insuranceDescription" => $insuranceDescription,
            "insuranceDuantion" => $insuranceDuantion,
            "insurancePrice" => $insurancePrice,
            "locationID" => $locationID,
            "state" => $state,
            "address" => $address,
            "mapCorrdination" => $mapCorrdination,
            "locationImg" => $locationImg,
            "promoID" => $promoID,
            "promoName" => $promoName,
            "promoDuration" => $promoDuration,
            "discountPercent" => $discountPercent,
            "promoImg" => $promoImg
        );
  
        array_push($products_arr["records"], $product_item);
    }
  
    // set response code - 200 OK
    http_response_code(200);
  
    // show products data
    echo json_encode($products_arr);
}
  
else{
    // set response code - 404 Not found
    http_response_code(404);
  
    // tell the user no products found
    echo json_encode(
        array("message" => "No products found.")
    );
}
?>