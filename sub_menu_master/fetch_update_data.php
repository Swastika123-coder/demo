<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header("Access-Control-Allow-Methods: POST");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Access-Control-Allow-Origin");

require_once "../db/db.php";

// GET POST DATA BY FORM POST
$postData = json_decode(file_get_contents("php://input"), true);

//  IF FORM POST DATA BLANK THEN GET POST DATA BY AJAX
if (empty($postData)) {
    $postData = json_decode($_POST['sendData'], true);
}

//  GET USER AUTHENTICATION TOKEN FROM FRONTEND
$auth_token = mysqli_real_escape_string($con, $postData['auth_token']);

//  GET USER LOGIN YES OR NOT AND IF LOGIN THEN USER DETAILS 
require_once "../function/user_auth.php";

//  CHECK USER VIEW PERMISSION 
if ($userDetails['view_permission'] == 'Yes') {

    //  GET ALL POST DATA 
    $sub_menu_code = mysqli_real_escape_string($con, $postData['sub_menu_code']);

    $sub_menu_dataget = mysqli_query($con,"select 
        sub_menu_master.sub_menu_code,
        sub_menu_master.sub_menu_name,
        sub_menu_master.menu_icon,
        sub_menu_master.menu_code,
        menu_master.menu_name,
        sub_menu_master.file_name,
        sub_menu_master.folder_name,
        sub_menu_master.order_num,
        sub_menu_master.active
        from sub_menu_master 
        LEFT JOIN menu_master ON menu_master.menu_code = sub_menu_master.menu_code
        where sub_menu_master.sub_menu_code='".$sub_menu_code."' ");
    $sub_menu_data = mysqli_fetch_row($sub_menu_dataget);

    if ($sub_menu_data) {
        $status = "Success";
        $message = "Sub Menu Details Fetched Successfully";
        $data = [
            'sub_menu_code' => $sub_menu_data[0],
            'sub_menu_name' => $sub_menu_data[1],
            'menu_icon' => $sub_menu_data[2],
            'menu_code' => $sub_menu_data[3],
            'menu_name' => $sub_menu_data[4],
            'file_name' => $sub_menu_data[5],
            'folder_name' => $sub_menu_data[6],
            'order_num' => $sub_menu_data[7],
            'active' => $sub_menu_data[8],
        ];
    } else {
        $status = "Not Found";
        $message = "Sub Menu Details Not Found";
    }
} else {
    //  IF USER HAVE NOT VIEW PERMISSION THEN SEND NO PERMISSION MESSAGE 
    $status = "No Permission";
    $message = "You Don't Have Permission To View Any Data !!";
}

$response = [
    'status' => $status,
    'message' => $message,
    'data' => $data,
];
header("HTTP/1.0 200 Success");

echo json_encode($response);
