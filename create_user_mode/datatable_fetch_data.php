<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header("Access-Control-Allow-Methods: POST");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Access-Control-Allow-Origin");

require_once "../db/db.php";

$auth_token = mysqli_real_escape_string($con, $_POST['auth_token']);

require_once "../function/user_auth.php";

if ($userDetails['view_permission'] == "Yes") {

    ## Read value
    $draw = $_POST['draw'];
    $row = $_POST['start'];
    $rowperpage = $_POST['length']; // Rows display per page
    $columnIndex = $_POST['order'][0]['column']; // Column index
    $columnName = $_POST['columns'][$columnIndex]['data']; // Column name
    $columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
    $searchValue = mysqli_real_escape_string($con, $_POST['search']['value']); // Search value


    ## Search 
	$searchQuery = " ";
	if($searchValue != ''){
		$searchQuery = " and (user_mode.user_mode like '%".$searchValue."%' or 
		user_mode.active like '%".$searchValue."%' ) ";
	}

	$query = "select 
				user_mode.user_mode_code,
				user_mode.user_mode, 
				user_mode.active
				from user_mode WHERE 1";

	## Total number of records without filtering
	$sel = mysqli_query($con,$query);
	$records = mysqli_num_rows($sel);
	$totalRecords = $records;

	## Total number of records with filtering
	$sel = mysqli_query($con,$query.$searchQuery);
	$records = mysqli_num_rows($sel);
	$totalRecordwithFilter =$records;

	## Fetch records
	$orderBy = "order by user_mode.".$columnName;
	
	$empQuery = $query.$searchQuery." ".$orderBy." ".$columnSortOrder." limit ".$row.",".$rowperpage;
	$empRecords = mysqli_query($con, $empQuery);
	$data = array();
	$i=1;
	while ($row = mysqli_fetch_assoc($empRecords)) {
		
		if($row['active']=="Yes"){
			$active = '<span class="label font-weight-bold label-lg  label-light-success label-inline">Yes</span>';
		}
		else{
			$active =  '<span class="label font-weight-bold label-lg  label-light-danger label-inline">No</span>';
		}
		
		$edit = 'onclick="update_data('.$i.')"';
		$delete = 'onclick="show_del_data_confirm_box('.$i.')"';

		$action =
			'<div class="dropdown dropdown-inline">
				<a href="javascript:;" class="btn btn-sm btn-clean btn-icon" data-toggle="dropdown"> <i class="la la-cog"></i> </a>
				<div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
					<ul class="nav nav-hoverable flex-column">
						<li class="nav-item">
							<a '.$edit.' class="nav-link" ><i class="text-success nav-icon fas fa-pen"></i><span class="nav-text">Edit Details</span></a>
						</li>
						<li class="nav-item">
							<a '.$delete.' class="nav-link" ><i class="text-danger nav-icon fas fa-trash"></i><span class="nav-text">Delete Details</span></a>
						</li>
					</ul>
				</div>
			</div>';
		
		$data[] = array(
				"user_mode"=>'<input type="hidden" class="user_mode_code_'.$i.'" value="'.$row['user_mode_code'].'" />'.$row['user_mode'],
				"active"=>$active,
				"action"=>$action,
			);
		$i++;
	}

    ## Response
    $response = array(
        "status" => "Success",
        "message" => "Fetch Successfully",
        "draw" => intval($draw),
        "iTotalRecords" => $totalRecords,
        "iTotalDisplayRecords" => $totalRecordwithFilter,
        "aaData" => $data
    );
} else {
    $response = array(
        "status" => "No Permission",
        "message" => "You Don't Have Permission To View Any Data !!",
        "draw" => '',
        "iTotalRecords" => '',
        "iTotalDisplayRecords" => '',
        "aaData" => ''
    );
}

header("HTTP/1.0 200 Success");

echo json_encode($response);
