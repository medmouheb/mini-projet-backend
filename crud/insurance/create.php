<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
// get database connection
include_once '../../config/database.php';
  
// instantiate insurance object
include_once '../../objects/insurance.php';
  
$database = new Database();
$db = $database->getConnection();
  
$insurance = new Insurance($db);
  
// get posted data
$data = json_decode(file_get_contents("php://input"));

// make sure data is not empty
if(
    !empty($data->insuranceName) &&
    !empty($data->insuranceDescription) &&
    !empty($data->insuranceDuantion) &&
    !empty($data->insurancePrice) 
    
){
  
    // set insurance property values
    $insurance->insuranceName = $data->insuranceName;
    $insurance->insuranceDescription = $data->insuranceDescription;
    $insurance->insuranceDuantion = $data->insuranceDuantion;
    $insurance->insurancePrice = $data->insurancePrice;
    

  
    // create the insurance
    if($insurance->create()){
  
        // set response code - 201 created
        http_response_code(201);
        // tell the user
        echo json_encode(array("message" => "insurance was created."));
    }
  
    // if unable to create the insurance, tell the user
    else{
  
        // set response code - 503 service unavailable
        http_response_code(503);
  
        // tell the user
        echo json_encode(array("message" => "Unable to create insurance."));
    }
}
  
// tell the user data is incomplete
else{
  
    // set response code - 400 bad request
    http_response_code(400);
    // tell the user
    echo json_encode(array("message" => "Unable to create insurance. Data is incomplete."));
}
?>