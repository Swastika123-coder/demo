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
    $system_name = mysqli_real_escape_string($con, $postData['system_name']);
    $email = mysqli_real_escape_string($con, $postData['email']);
    $address = mysqli_real_escape_string($con, $postData['address']);
    $ph_num = mysqli_real_escape_string($con, $postData['ph_num']);

    $logo = mysqli_real_escape_string($con, $postData['logo']);
    $favicon = mysqli_real_escape_string($con, $postData['favicon']);

    $logo_FileType = pathinfo($logo, PATHINFO_EXTENSION);
    if (!in_array($logo_FileType, $allowedImgExt)) {
        $logo = "";
    }

    $favicon_FileType = pathinfo($favicon, PATHINFO_EXTENSION);
    if (!in_array($favicon_FileType, $allowedImgExt)) {
        $favicon = "";
    }

    $dataget = mysqli_query($con, "select * from system_info ");
    $data = mysqli_fetch_row($dataget);

    //  IF NOT GET ANY DATA THEN INSERT
    if (!$dataget) {

        //  CHECK USER ENTERY PERMISSION 
        if ($userDetails['entry_permission'] == 'Yes') {

            //  INSERT IN SYSTEM INFO 
            mysqli_query($con, "insert into system_info (
                    id, 
                    system_name, 
                    logo, 
                    favicon, 
                    email, 
                    address, 
                    ph_num, 
                    entry_user_code) values(null,
                    '" . $system_name . "',
                    '" . $logo . "',
                    '" . $favicon . "',
                    '" . $email . "',
                    '" . $address . "',
                    '" . $ph_num . "',
                    '" . $session_user_code . "')");

            $status = "Success";
            $message = "Data Saved Successfully";
            $activity_details = "You Insert A Record In Manage System Info";
        } else {
            //  IF USER HAVE NOT ENTRY PERMISSION THEN SEND NO PERMISSION MESSAGE 
            $status = "No Permission";
            $message = "You Don't Have Permission To Entry Any Data !!";
        }
    }
    //  IF GET ANY DATA THEN UPDATE
    else {

        //  CHECK USER EDIT PERMISSION 
        if ($userDetails['edit_permission'] == 'Yes') {

            mysqli_query($con, "update system_info 
						set system_name='" . $system_name . "', 
						email='" . $email . "', 
						address='" . $address . "', 
						ph_num='" . $ph_num . "', 
						entry_user_code='" . $session_user_code . "', 
						update_timestamp='" . $timestamp . "' 
						where 1 ");

            $dataget = mysqli_query($con, "select logo, favicon from system_info where 1 ");
            $data = mysqli_fetch_row($dataget);
            $previous_logo = $data[0];
            $previous_favicon = $data[1];

            if ($logo != "") {
                mysqli_query($con, "update system_info set logo='" . $logo . "' where 1 ");
                if ($previous_logo != "") {
                    unlink("../../../../upload_content/upload_img/system_img/" . $previous_logo);
                }
            }
            if ($favicon != "") {
                mysqli_query($con, "update system_info set favicon='" . $favicon . "' where 1 ");
                if ($previous_favicon != "") {
                    unlink("../../../../upload_content/upload_img/system_img/" . $previous_favicon);
                }
            }

            $status = "Success";
            $message = "Data Updated Successfully";
            $activity_details = "You Update A Record In Manage System Info";

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
