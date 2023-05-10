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

$data = array();

//  CHECK USER VIEW PERMISSION 
if ($userDetails['view_permission'] == 'Yes') {

    //  GET ALL POST DATA 
    $search = $_POST['searchTerm'];

    $fetchData = mysqli_query($con,"select menu_code, menu_name from menu_master where active='Yes' and menu_name like '%".$search."%' limit 50");
        
    $data = array();

    while ($row = mysqli_fetch_array($fetchData)) {
        $data[] = array("id"=>$row['menu_code'], "text"=>$row['menu_name']);
    }
    
}

header("HTTP/1.0 200 Success");

echo json_encode($data);
