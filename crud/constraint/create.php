<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
// get database connection
include_once '../../config/database.php';
  
// instantiate car object
include_once '../../objects/constraint.php';
  
$database = new Database();
$db = $database->getConnection();
  
$constraint = new Constraint($db);
  
// get posted data
$data = json_decode(file_get_contents("php://input"));
  
// make sure data is not empty
if(
    !empty($data->carID) &&
    !empty($data->totalPrice) &&
    !empty($data->promoID) &&
    !empty($data->insuranceID) &&
    !empty($data->locationID) &&
    !empty($data->clientID) 
    
){
  
    // set constraint property values
    $constraint->carID = $data->carID;
    $constraint->totalPrice = $data->totalPrice;
    $constraint->promoID = $data->promoID;
    $constraint->insuranceID = $data->insuranceID;
    $constraint->locationID = $data->locationID;
    $constraint->clientID = $data->clientID;
    

  
    // create the constraint
    if($constraint->create()){
  
        // set response code - 201 created
        http_response_code(201);
        // tell the user
        echo json_encode(array("message" => "constarint was created."));
    }
  
    // if unable to create the constraint, tell the user
    else{
  
        // set response code - 503 service unavailable
        http_response_code(503);
  
        // tell the user
        echo json_encode($data);
        echo json_encode(array("message" => "Unable to create constraint."));
    }
}
  
// tell the user data is incomplete
else{
  
    // set response code - 400 bad request
    http_response_code(400);
  
    // tell the user
    echo json_encode(array("message" => "Unable to create constraint. Data is incomplete."));
}
?>

