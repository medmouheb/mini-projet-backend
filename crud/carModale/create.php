<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
// get database connection
include_once '../../config/database.php';
  
// instantiate carModale object
include_once '../../objects/carModale.php';
  
$database = new Database();
$db = $database->getConnection();
  
$carModale = new CarModale($db);
  
// get posted data
$data = json_decode(file_get_contents("php://input"));
  
// make sure data is not empty
if(
    !empty($data->carName) &&
    !empty($data->carFamily) &&
    !empty($data->carPrice) &&
    !empty($data->nombreOfPlaces) &&
    !empty($data->nombreOfCylindres) &&
    !empty($data->img1) &&
    !empty($data->img2) &&
    !empty($data->img3) &&
    !empty($data->img4) &&
    !empty($data->consomtion) &&
    !empty($data->boite) &&
    !empty($data->energie)  
    
){
  
    // set carModale property values
    $carModale->carName = $data->carName;
    $carModale->carFamily = $data->carFamily;
    $carModale->carPrice = $data->carPrice;
    $carModale->nombreOfPlaces = $data->nombreOfPlaces;
    $carModale->nombreOfCylindres = $data->nombreOfCylindres;
    $carModale->img1 = $data->img1;
    $carModale->img2 = $data->img2;
    $carModale->img3 = $data->img3;
    $carModale->img4 = $data->img4;
    $carModale->consomtion = $data->consomtion;
    $carModale->boite = $data->boite;
    $carModale->energie = $data->energie;
    

  
    // create the carModale
    if($carModale->create()){
  
        // set response code - 201 created
        http_response_code(201);
  
        // tell the user
        echo json_encode(array("message" => "carModale was created."));
    }
  
    // if unable to create the carModale, tell the user
    else{
  
        // set response code - 503 service unavailable
        http_response_code(503);
  
        // tell the user
        echo json_encode(array("message" => "Unable to create carModale."));
    }
}
  
// tell the user data is incomplete
else{
  
    // set response code - 400 bad request
    http_response_code(400);
  
    // tell the user
    echo json_encode(array("message" => "Unable to create carModale. Data is incomplete."));
}
?>