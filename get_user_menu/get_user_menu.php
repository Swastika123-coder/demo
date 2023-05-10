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

if ($login=="Yes") {
    $status = "Success";
    $message = "User Menu List Fetched";
    $data = [];

    if ($userDetails['user_mode_code'] == "Project Admin") {
        $menuQuery = "select menu_code,menu_name,menu_icon,sub_menu_status,file_name,folder_name from menu_master where active='Yes' order by order_num ";
    } else {
        $menuQuery = "select 
                    menu_master.menu_code,
                    menu_master.menu_name,
                    menu_master.menu_icon,
                    menu_master.sub_menu_status,
                    menu_master.file_name,
                    menu_master.folder_name
                    from menu_master RIGHT JOIN user_permission ON user_permission.all_menu_code=menu_master.menu_code where menu_master.active='Yes' and user_permission.user_mode_code='" . $userDetails['user_mode_code'] . "' order by order_num ";
    }
    
    $menu_dataget = mysqli_query($con, $menuQuery);
    while ($menu_rw = mysqli_fetch_assoc($menu_dataget)) {

        $menuData = [
            "menu_code" => $menu_rw['menu_code'],
            "menu_name" => $menu_rw['menu_name'],
            "menu_icon" => $menu_rw['menu_icon'],
            "sub_menu_status" => $menu_rw['sub_menu_status'],
            "file_name" => $menu_rw['file_name'],
            "folder_name" => $menu_rw['folder_name'],
        ];

        if ($menu_rw['sub_menu_status'] == "Yes") {
            
            $subMenuData = [];

            if ($userDetails['user_mode_code'] == "Project Admin") {
                $submenuQuery = "select sub_menu_name,menu_icon,file_name,folder_name from sub_menu_master where menu_code='" . $menu_rw['menu_code'] . "' and active='Yes' order by order_num ";
            } else {
                $submenuQuery = "select 
                sub_menu_master.sub_menu_name,
                sub_menu_master.menu_icon,
                sub_menu_master.file_name,
                sub_menu_master.folder_name
                from sub_menu_master RIGHT JOIN user_permission ON user_permission.all_menu_code=sub_menu_master.sub_menu_code where sub_menu_master.menu_code='" . $menu_rw['menu_code'] . "' and sub_menu_master.active='Yes' and user_permission.user_mode_code='" . $userDetails['user_mode_code'] . "' order by order_num ";
            }
            
            $sub_menu_dataget = mysqli_query($con, $submenuQuery);
            while ($sub_menu_rw = mysqli_fetch_array($sub_menu_dataget)) {
                $subMenuData[] = [
                    "sub_menu_name" => $sub_menu_rw['sub_menu_name'],
                    "menu_icon" => $sub_menu_rw['menu_icon'],
                    "file_name" => $sub_menu_rw['file_name'],
                    "folder_name" => $sub_menu_rw['folder_name'],
                ];
            }

            $data[] = ["menuData" => $menuData, "subMenuData" => $subMenuData];
        }


    }
}
else{
    $status = "Session Destroy";
    $message = "Please Re-Login";
}

$response = [
    'status' => $status,
    'message' => $message,
    'data' => $data,
];
header("HTTP/1.0 200 Success");

echo json_encode($response);