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

//  IF LOGIN YES THEN EXECUTE 
if ($login == "Yes") {

    //  GET ALL POST DATA 
    $menu_code = mysqli_real_escape_string($con, $postData['menu_code']);
    $menu_name = mysqli_real_escape_string($con, $postData['menu_name']);
    $menu_icon = mysqli_real_escape_string($con, $postData['menu_icon']);
    $sub_menu_status = mysqli_real_escape_string($con, $postData['sub_menu_status']);
    $file_name = mysqli_real_escape_string($con, $postData['file_name']);
    $folder_name = mysqli_real_escape_string($con, $postData['folder_name']);
    $order_num = mysqli_real_escape_string($con, $postData['order_num']);
    $active = mysqli_real_escape_string($con, $postData['active']);

    //  IF MENU CODE BLANK THEN INSERT
    if ($menu_code == "") {

        //  CHECK USER ENTERY PERMISSION 
        if ($userDetails['entry_permission'] == 'Yes') {

            // CHECK MENU NAME, PAGE NAME, FOLDER NAME EXIST OR NOT
            if ($sub_menu_status == 'Yes') {
                $dataget = mysqli_query($con, "select * from menu_master where menu_name='" . $menu_name . "' ");
                $data_num_row = mysqli_num_rows($dataget);
            } else {
                $dataget = mysqli_query($con, "select * from menu_master where menu_name='" . $menu_name . "' OR file_name='" . $file_name . "' OR folder_name='" . $folder_name . "' ");
                $data_num_row = mysqli_num_rows($dataget);
            }

            //  IF NOT EXIST THEN INSERT DATA 
            if ($data_num_row == 0) {
                $menu_code = "MC_" . uniqid() . time();
                // INSERT IN MENU MASTER
                mysqli_query($con, "insert into menu_master (
								id, 
								menu_code, 
								menu_name, 
								menu_icon, 
								sub_menu_status, 
								file_name, 
								folder_name, 
								order_num, 
								active, 
								entry_user_code) values(null,
								'" . $menu_code . "',
								'" . $menu_name . "',
								'" . $menu_icon . "',
								'" . $sub_menu_status . "',
								'" . $file_name . "',
								'" . $folder_name . "',
								'" . $order_num . "',
								'" . $active . "',
								'" . $session_user_code . "')");

                $status = "Success";
                $message = "Data Saved Successfully";
                $activity_details = "You Insert A Record In Manage Menu Details";
            } else {
                $status = "Exist";
                $message = "Already Exist Same Data !!";
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

            //  CHECK MENU NAME, PAGE NAME, FOLDER NAME EXIST OR NOT 
            if ($sub_menu_status == 'Yes') {
                $dataget = mysqli_query($con, "select * from menu_master where  menu_code<>'" . $menu_code . "' and menu_name='" . $menu_name . "' ");
                $data_num_row = mysqli_num_rows($dataget);
            } else {
                $dataget = mysqli_query($con, "select * from menu_master where  menu_code<>'" . $menu_code . "' and (menu_name='" . $menu_name . "' OR file_name='" . $file_name . "' OR folder_name='" . $folder_name . "') ");
                $data_num_row = mysqli_num_rows($dataget);
            }

            //  IF NOT EXIST THEN UPDATE 
            if ($data_num_row == 0) {
                mysqli_query($con, "update menu_master set 
					menu_name='" . $menu_name . "', 
					menu_icon='" . $menu_icon . "', 
					sub_menu_status='" . $sub_menu_status . "', 
					file_name='" . $file_name . "', 
					folder_name='" . $folder_name . "', 
					order_num='" . $order_num . "', 
					active='" . $active . "', 
					entry_user_code='" . $session_user_code . "', 
					update_timestamp='" . $timestamp . "' 
					where menu_code='" . $menu_code . "' ");

                $status = "Success";
                $message = "Data Updated Successfully";
                $activity_details = "You Update A Record In Manage Menu Details";
            } else {
                $status = "Exist";
                $message = "Already Exist Same Data !!";
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
