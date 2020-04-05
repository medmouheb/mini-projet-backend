<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
// include database and object files
include_once '../../config/database.php';
include_once '../../objects/carmodale.php';
  
// get database connection
$database = new Database();
$db = $database->getConnection();
  
// prepare product object
$product = new CarModale($db);
  
// get id of product to be edited
$data = json_decode(file_get_contents("php://input"));
  
// set ID property of product to be edited
$product->carModaleID = $data->carModaleID;
  
// set product property values
$product->carName = $data->carName;
$product->carFamily = $data->carFamily;
$product->carPrice = $data->carPrice;
$product->nombreOfPlaces = $data->nombreOfPlaces;
$product->nombreOfCylindres = $data->nombreOfCylindres;
$product->img1 = $data->img1;
$product->img2 = $data->img2;
$product->img3 = $data->img3;
$product->img4 = $data->img4;
$product->energie = $data->energie;
$product->consomtion = $data->consomtion;
$product->boite = $data->boite;
 
  
// update the product
if($product->update()){
  
    // set response code - 200 ok
    http_response_code(200);
  
    // tell the user
    echo json_encode(array("message" => "Product was updated."));
}
  
// if unable to update the product, tell the user
else{
  
    // set response code - 503 service unavailable
    http_response_code(503);
  
    // tell the user
    echo json_encode(array("message" => "Unable to update product."));
}
?>