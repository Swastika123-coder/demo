<?php
require_once '../db/db.php';

//  VERIFY USER AUTH TOKEN & GET USER CODE FROM AUTH_TOKEN 
require_once 'jwt-token.php';
$userPayload = verify($auth_token);
$user_code = $userPayload['user_code'];

//  VERIFY USER FROM USER TABLE 
$user_dataget = mysqli_query($con, "SELECT 
    user_master.user_code,
    user_master.user_id,
    user_master.name,
    user_master.email,
    user_master.profile_img,
    user_master.user_mode_code,
    user_mode.user_mode,
    user_master.active,
    user_master.entry_permission,
    user_master.view_permission,
    user_master.edit_permission,
    user_master.delete_permissioin
    FROM user_master 
    LEFT JOIN user_mode ON user_mode.user_mode_code = user_master.user_mode_code
    WHERE user_master.user_code='" . $user_code . "' and user_master.active='Yes' ");
$user_data = mysqli_fetch_row($user_dataget);

//  BY DEFAULT USER LOGIN NO & USER DETAILS BLANK ARRAY
$login = 'No';
$userDetails = [];

//  IF USER EXIST THEN SEND LOGIN YES & SEND USER DETAILS ARRAY 
if ($user_data) {
    $login = "Yes";
    $userDetails = [
        "user_code" => $user_data[0],
        "user_id" => $user_data[1],
        "name" => $user_data[2],
        "email" => $user_data[3],
        "profile_img" => $user_data[4],
        "user_mode_code" => $user_data[5],
        "user_mode" => $user_data[6],
        "active" => $user_data[7],
        "entry_permission" => $user_data[8],
        "view_permission" => $user_data[9],
        "edit_permission" => $user_data[10],
        "delete_permissioin" => $user_data[11],
    ];
}
