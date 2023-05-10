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

    ## Read value (COPY & PASTE)
    $draw = $_POST['draw'];
    $row = $_POST['start'];
    $rowperpage = $_POST['length']; // Rows display per page
    $columnIndex = $_POST['order'][0]['column']; // Column index
    $columnName = $_POST['columns'][$columnIndex]['data']; // Column name
    $columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
    $searchValue = mysqli_real_escape_string($con, $_POST['search']['value']); // Search value


    ## Search 
    $searchQuery = " ";
    if ($searchValue != '') {
        $searchQuery = " and (menu_master.menu_name like '%" . $searchValue . "%' or 
        menu_master.file_name like '%" . $searchValue . "%' or 
        menu_master.folder_name like'%" . $searchValue . "%' ) ";
    }

    $query = "select 
    menu_master.menu_code,
    menu_master.menu_name,
    menu_master.menu_icon,
    menu_master.icon_color,
    menu_master.sub_menu_status,
    menu_master.file_name,
    menu_master.folder_name,
    menu_master.active,
    menu_master.order_num
    from menu_master ";

    ## Total number of records without filtering
    $sel = mysqli_query($con, $query);
    $records = mysqli_num_rows($sel);
    $totalRecords = $records;

    ## Total number of records with filtering
    $sel = mysqli_query($con, $query . " WHERE 1 " . $searchQuery);
    $records = mysqli_num_rows($sel);
    $totalRecordwithFilter = $records;

    ## Fetch records
    $empQuery = $query . " WHERE 1 " . $searchQuery . " order by " . $columnName . " " . $columnSortOrder . " limit " . $row . "," . $rowperpage;
    $empRecords = mysqli_query($con, $empQuery);
    $data = array();
    $i = 1;
    while ($row = mysqli_fetch_assoc($empRecords)) {

        $active =  '<span class="label font-weight-bold label-lg  label-light-danger label-inline">No</span>';
        if ($row['active'] == "Yes") {
            $active = '<span class="label font-weight-bold label-lg  label-light-success label-inline">Yes</span>';
        }

        $sub_menu_status =  '<span class="label font-weight-bold label-lg  label-light-danger label-inline">No</span>';
        if ($row['sub_menu_status'] == "Yes") {
            $sub_menu_status = '<span class="label font-weight-bold label-lg  label-light-success label-inline">Yes</span>';
        }

        $edit = 'onclick="update_data(' . $i . ')"';

        $delete = 'onclick="show_del_data_confirm_box(' . $i . ')"';

        $action =
            '<div class="dropdown dropdown-inline">
            <a href="javascript:;" class="btn btn-sm btn-clean btn-icon" data-toggle="dropdown"> <i class="la la-cog"></i> </a>
            <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                <ul class="nav nav-hoverable flex-column">
                    <li class="nav-item">
                        <a ' . $edit . ' class="nav-link" ><i class="text-success nav-icon fas fa-pen"></i><span class="nav-text">Edit Details</span></a>
                    </li>
                    <li class="nav-item">
                        <a ' . $delete . ' class="nav-link" ><i class="text-danger nav-icon fas fa-trash"></i><span class="nav-text">Delete Details</span></a>
                    </li>
                </ul>
            </div>
        </div>';

        $data[] = array(
            "menu_name" => '<input type="hidden" class="menu_code_' . $i . '" value="' . $row['menu_code'] . '" /><i class="' . $row['menu_icon'] . ' mr-2"></i>' . $row['menu_name'],
            "sub_menu_status" => $sub_menu_status,
            "file_name" => $row['file_name'],
            "folder_name" => $row['folder_name'],
            "order_num" => $row['order_num'],
            "active" => $active,
            "action" => $action,
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
