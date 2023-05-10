<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header("Access-Control-Allow-Methods: POST");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Access-Control-Allow-Origin");

require_once "../db/db.php";

$postData = json_decode(file_get_contents("php://input"), true);

if (empty($postData)) {
    $postData = json_decode($_POST['sendData'], true);
}

$auth_token = mysqli_real_escape_string($con, $postData['auth_token']);
$pg_nm = mysqli_real_escape_string($con, $postData['pg_nm']);
$urlMenuCode = mysqli_real_escape_string($con, $postData['urlMenuCode']);

require_once "../function/user_auth.php";

$sub_menu_dataget = mysqli_query($con, "select sub_menu_code from sub_menu_master where file_name='" . $pg_nm . "' ");
$sub_menu_data = mysqli_fetch_row($sub_menu_dataget);

$sub_menu_code = $sub_menu_data[0];

if ($sub_menu_code == "") {
    $allMenuCode = $urlMenuCode;
} else {
    $allMenuCode = $sub_menu_code;
}

$check_user_page_access_dataget = mysqli_query($con, "select * from user_permission where user_mode_code='" . $userDetails['user_mode_code'] . "' and all_menu_code='" . $allMenuCode . "' ");
$check_user_page_access_data = mysqli_num_rows($check_user_page_access_dataget);

if ($userDetails['user_mode_code'] == "Project Admin" || $allMenuCode == "") {
    $check_user_page_access_data = 1;
}

$access = 'No';

if ($check_user_page_access_data==1) {
    $access = 'Yes';
}

$response = [
    'access' => $access,
];
header("HTTP/1.0 200 Success");

echo json_encode($response);
