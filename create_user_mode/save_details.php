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
    $user_mode_code = mysqli_real_escape_string($con,$postData['user_mode_code']);
    $user_mode = mysqli_real_escape_string($con,$postData['user_mode']);
    $active = mysqli_real_escape_string($con,$postData['active']);

    //  IF CODE BLANK THEN INSERT
    if ($user_mode_code == "") {

        //  CHECK USER ENTERY PERMISSION 
        if ($userDetails['entry_permission'] == 'Yes') {

            $execute = 1;

            // CHECK SUB MENU NAME, PAGE NAME, FOLDER NAME EXIST OR NOT
            $dataget = mysqli_query($con,"select * from sub_menu_master where sub_menu_name='".$sub_menu_name."' OR file_name='".$file_name."' OR folder_name='".$folder_name."' ");
			$data_num_row = mysqli_num_rows($dataget);

            $dataget = mysqli_query($con,"select * from user_mode where user_mode='".$user_mode."' ");
			$data_num_row = mysqli_num_rows($dataget);

            if ($data_num_row!=0) {
                $status = "User Mode Exist";
                $message = "Already Exist Same User Mode !!";
                $execute = 0;
            }

            //  IF NOT EXIST THEN INSERT DATA 
            if ($execute == 1) {
                $user_mode_code = "UMC_".uniqid().time();
				//  INSERT IN TABLE 
				mysqli_query($con,"insert into sub_menu_master (
						id, 
						sub_menu_code, 
						sub_menu_name, 
						menu_icon, 
						menu_code, 
						file_name, 
						folder_name, 
						order_num, 
						active, 
						entry_user_code) values(null,
						'".$sub_menu_code."',
						'".$sub_menu_name."',
						'".$menu_icon."',
						'".$menu_code."',
						'".$file_name."',
						'".$folder_name."',
						'".$order_num."',
						'".$active."',
						'".$session_user_code."')");

                $status = "Success";
                $message = "Data Saved Successfully";
                $activity_details = "You Insert A Record In Manage Sub Menu Details";
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

            //  CHECK SUB MENU NAME, PAGE NAME, FOLDER NAME EXIST OR NOT 
            $dataget = mysqli_query($con,"select * from sub_menu_master where  sub_menu_code<>'".$sub_menu_code."' and (sub_menu_name='".$sub_menu_name."' OR file_name='".$file_name."' OR folder_name='".$folder_name."') ");
			$data_num_row = mysqli_num_rows($dataget);

            //  IF NOT EXIST THEN UPDATE 
            if ($data_num_row == 0) {
                mysqli_query($con,"update sub_menu_master set 
					sub_menu_name='".$sub_menu_name."', 
					menu_icon='".$menu_icon."', 
					menu_code='".$menu_code."', 
					file_name='".$file_name."', 
					folder_name='".$folder_name."', 
					order_num='".$order_num."', 
					active='".$active."', 
					entry_user_code='".$session_user_code."', 
					update_timestamp='".$timestamp."' 
					where sub_menu_code='".$sub_menu_code."' ");

                $status = "Success";
                $message = "Data Updated Successfully";
                $activity_details = "You Update A Record In Manage Sub Menu Details";
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
