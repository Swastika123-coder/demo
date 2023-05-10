<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header("Access-Control-Allow-Methods: POST");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Access-Control-Allow-Origin");

require_once "../db/db.php";

$postData = json_decode(file_get_contents("php://input"),true);

if (empty($postData)) {
    $postData = json_decode($_POST['sendData'],true);
}

$user_id = mysqli_real_escape_string($con,$postData['user_id']);
$password = mysqli_real_escape_string($con,$postData['password']);
$encodePassword = base64_encode($password);

$execute = 1;

// CHECK USER ID EXIT OR NOT
$check_user_id_dataget = mysqli_query($con,"select * from user_master where user_id='".$user_id."' ");
if (mysqli_num_rows($check_user_id_dataget)!=1) {
    $status = "Not Found";
    $message = "User Id Not Found";
    $execute = 0;
}


// CHECK USER CREDENTIAL
if ($execute==1) {
    $user_dataget = mysqli_query($con,"select user_code from user_master where user_id='".$user_id."' and user_password='".$encodePassword."' and active='Yes' ");
    $user_data = mysqli_fetch_row($user_dataget);

    if ($user_data) {
        $user_code = $user_data[0];
        $status = "Success";
        $message = "Login Successfully";
        require_once "../function/jwt-token.php";
        $token = Sign(["user_code" => $user_code]);
    }
    else {
        $status = "Not Match";
        $message = "Password Not Match";
    }
}

$response = [
    'status' => $status,
    'message' => $message,
    'token' => $token,
];
header("HTTP/1.0 200 Success");

echo json_encode($response);
