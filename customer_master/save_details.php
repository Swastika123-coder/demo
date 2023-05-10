+<?php
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

//  IF LOGIN YES THEN EXECUTE 
if ($login == "Yes") {

    //  GET ALL POST DATA 
    $customer_code = mysqli_real_escape_string($con, $postData['customer_code']);
    $name = mysqli_real_escape_string($con, $postData['name']);
    $ph_num = mysqli_real_escape_string($con, $postData['ph_num']);
    $address = mysqli_real_escape_string($con, $postData['address']);

    //  IF CODE BLANK THEN INSERT
    if ($customer_code == "") {

        //  CHECK USER ENTERY PERMISSION 
        if ($userDetails['entry_permission'] == 'Yes') {

            $execute = 1;

            // CHECK PHONE NUMBER EXIST OR NOT
            $customer_ph_num_dataget = mysqli_query($con, "select * from customer_master where ph_num='" . $ph_num . "' ");
            $customer_ph_num_data = mysqli_fetch_row($customer_ph_num_dataget);

            if ($customer_ph_num_data) {
                $status = "Phone Number Exist";
                $message = "Phjkbgfg";
                $execute = 0;
            }


            //  IF NOT EXIST THEN INSERT DATA 
            if ($execute == 1) {
                $customer_code = "CUC_" . uniqid() . time();
                // INSERT IN TABLE
                mysqli_query($con, "insert into customer_master (
								id, 
								customer_code, 
								name, 
								ph_num, 
								address, 
								entry_user_code) values(null,
								'" . $customer_code . "',
								'" . $name . "',
								'" . $ph_num . "',
								'" . $address . "',
								'" . $userDetails['user_code'] . "')");

                $status = "Success";
                $message = "Data Saved Successfully";
                $activity_details = "You Insert A Record In Customer Master Table";
            }
        } else {
            //  IF USER HAVE NOT ENTRY PERMISSION THEN SEND NO PERMISSION MESSAGE 
            $status = "No Permission";
            $message = "You Don't Have Permission To Entry Any Data !!";
        }
    }
    //  IF MENU CODE DOES NOT BLANK THEN UPDATE 
    else {

        //  CHECK USER EDIT PERMISSION 
        if ($userDetails['edit_permission'] == 'Yes') {

            $execute = 1;

            // CHECK PHONE NUMBER EXIST OR NOT
            $customer_ph_num_dataget = mysqli_query($con, "select * from customer_master where customer_code<>'".$customer_code."' and ph_num='" . $ph_num . "' ");
            $customer_ph_num_data = mysqli_fetch_row($customer_ph_num_dataget);

            if ($customer_ph_num_data) {
                $status = "Phone Number Exist";
                $message = "Phjkbgfg";
                $execute = 0;
            }

            //  IF NOT EXIST THEN UPDATE 
            if ($data_num_row == 0) {
                mysqli_query($con, "update customer_master set 
                    name='" . $name . "', 
					ph_num='" . $ph_num . "', 
					address='" . $address . "',
					entry_user_code='" . $userDetails['user_code'] . "', 
					update_timestamp='" . $timestamp . "' 
					where customer_code='" . $customer_code . "' ");

                $status = "Success";
                $message = "Data Updated Successfully";
                $activity_details = "You Update A Record In Customer mas";
            } 
            
        } else {
            //  IF USER HAVE NOT EDIT PERMISSION THEN SEND NO PERMISSION MESSAGE 
            $status = "No Permission";
            $message = "You Don't Have Permission To Edit Any Data !!";
        }
    }
} else {
    //  IF NOT LOGIN THEN SEND SESSION DESTROY MESSAGE 
    $status = "Session Destroy";
    $message = "";
}

//  INSERT USER ACTIVITY DETAILS 
require_once "../function/store_activity.php";
if ($activity_details != "") {
    insertActivity($activity_details, $con, $userDetails['user_code']);
}

$response = [
    'status' => $status,
    'message' => $message,
];
header("HTTP/1.0 200 Success");

echo json_encode($response);
