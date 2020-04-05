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
include_once '../../objects/car.php';
  
$database = new Database();
$db = $database->getConnection();
  
$car = new Car($db);
  
// get posted data
$data = json_decode(file_get_contents("php://input"));
  
// make sure data is not empty
if(
    !empty($data->carModaleID) &&
    !empty($data->pricePerDay) &&
    !empty($data->color)
){
  
    // set car property values
    $car->carModaleID = $data->carModaleID;
    $car->pricePerDay = $data->pricePerDay;
    $car->color = $data->color;

  
    // create the car
    if($car->create()){
  
        // set response code - 201 created
        http_response_code(201);
        // tell the user
        echo json_encode(array("message" => "car was created."));
    }
  
    // if unable to create the car, tell the user
    else{
  
        // set response code - 503 service unavailable
        http_response_code(503);
  
        // tell the user
        echo json_encode($data);
        echo json_encode(array("message" => "Unable to create car."));
    }
}
  
// tell the user data is incomplete
else{
  
    // set response code - 400 bad request
    http_response_code(400);
  
    // tell the user
    echo json_encode(array("message" => "Unable to create car. Data is incomplete."));
}
?>