<?php
// required headers
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// files needed to connect to database
include_once '../../config/database.php';
include_once '../../objects/clients.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// instantiate product object
$user = new Client($db);
 
// get posted data
$data = json_decode(file_get_contents("php://input"));
 
// set product property values
$user->fistname = $data->fistname;
$user->lastname = $data->lastname;
$user->email = $data->email;
$user->password = $data->password;
$user->tel = $data->tel;
$user->address = $data->address;
 
// create the user
if(
    !empty($user->fistname) &&
    !empty($user->lastname) &&
    !empty($user->email) &&
    !empty($user->password) &&
    !empty($user->tel) &&
    !empty($user->address) &&
    $user->create()
){
 
    // set response code
    http_response_code(200);
 
    // display message: user was created
    echo json_encode(array("message" => "User was created."));
}
 
// message if unable to create user
else{
 
    // set response code
    http_response_code(400);
 
    // display message: unable to create user
    echo json_encode(array("message" => "Unable to create user."));
}
?>