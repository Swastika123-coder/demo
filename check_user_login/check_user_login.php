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

$auth_token = mysqli_real_escape_string($con,$postData['auth_token']);

require_once "../function/user_auth.php";

$response = [
    'login' => $login,
    'userDetails' => $userDetails,
];
header("HTTP/1.0 200 Success");

echo json_encode($response);
