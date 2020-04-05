<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
// get database connection
include_once '../../config/database.php';
  
// instantiate location object
include_once '../../objects/promo.php';
  
$database = new Database();
$db = $database->getConnection();
  
$promo = new Promo($db);
  
// get posted data
$data = json_decode(file_get_contents("php://input"));

// make sure data is not empty
if(
    !empty($data->promoName) &&
    !empty($data->promoDuration) &&
    !empty($data->discountPercent) &&
    !empty($data->promoImg) 
    
){
  
    // set promo property values
    $promo->promoName = $data->promoName;
    $promo->promoDuration = $data->promoDuration;
    $promo->discountPercent = $data->discountPercent;
    $promo->promoImg = $data->promoImg;
    

  
    // create the promo
    if($promo->create()){
  
        // set response code - 201 created
        http_response_code(201);
        // tell the user
        echo json_encode(array("message" => "promo was created."));
    }
  
    // if unable to create the promo, tell the user
    else{
  
        // set response code - 503 service unavailable
        http_response_code(503);
  
        // tell the user
        echo json_encode(array("message" => "Unable to create promo."));
    }
}
  
// tell the user data is incomplete
else{
  
    // set response code - 400 bad request
    http_response_code(400);
    // tell the user
    echo json_encode(array("message" => "Unable to create promo. Data is incomplete."));
}
?>