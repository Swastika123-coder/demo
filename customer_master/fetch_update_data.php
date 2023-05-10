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
    $customer_code = mysqli_real_escape_string($con, $postData['customer_code']);

    $customer_dataget = mysqli_query($con, "select 
	customer_code,
	name,
	ph_num,
	address
	from customer_master where customer_code='" . $customer_code . "' ");
    $customer_data = mysqli_fetch_row($customer_dataget);

    if ($customer_data) {
        $status = "Success";
        $message = "Customer Details Fetched Successfully";
        $data = [
            'customer_code' => $customer_data[0],
            'name' => $customer_data[1],
            'ph_num' => $customer_data[2],
            'address' => $customer_data[3],
        ];
    } else {
        $status = "Not Found";
        $message = "Menu Details Not Found";
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
