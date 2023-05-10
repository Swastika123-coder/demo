<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header("Access-Control-Allow-Methods: POST");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Access-Control-Allow-Origin");

require_once "../db/db.php";

$query = "SELECT system_name, logo, favicon, email, address, ph_num FROM system_info";
$system_info_dataget = mysqli_query($con,$query);
$system_info_data = mysqli_fetch_row($system_info_dataget);

$logo = $system_info_data[1]=="" ? "no_image.png" : $system_info_data[1];
$favicon = $system_info_data[2]=="" ? "no_image.png" : $system_info_data[2];

if ($system_info_data) {
    $data = [
        "system_name" => $system_info_data[0],
        "logo" => $logo,
        "favicon" => $favicon,
        "email" => $system_info_data[3],
        "address" => $system_info_data[4],
        "ph_num" => $system_info_data[5],
    ];
}
else{
    $data = [
        "system_name" => "Admin System",
        "logo" => "no_image.png",
        "favicon" => "no_image.png",
        "email" => "admin@admin.com",
        "address" => "",
        "ph_num" => "",
    ];
}

$response = [
    'status' => "Success",
    'message' => "System Info Fetched Successfully",
    'data' => $data,
];
header("HTTP/1.0 200 Success");

echo json_encode($response);