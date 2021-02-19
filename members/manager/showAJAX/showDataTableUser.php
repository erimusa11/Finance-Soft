<?php

include '../../../dbconnection.php';
## Read value
$draw = $_POST['draw'];
$row = $_POST['start'];
$rowperpage = $_POST['length']; // Rows display per page
$columnIndex = $_POST['order'][0]['column']; // Column index
$columnName = $_POST['columns'][$columnIndex]['data']; // Column name
$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
$searchValue = mysqli_real_escape_string($connection, $_POST['search']['value']); // Search value

## Search
$searchQuery = " ";
if ($searchValue != '') {
    $searchQuery = " and (name like '%" . $searchValue . "%' or 
   lastname like '%" . $searchValue . "%' or 
   phone like'%" . $searchValue . "%'  or 
   email like'%" . $searchValue . "%') ";
}

## Total number of records without filtering
$sel = mysqli_query($connection, "select count(*) as allcount from user");
$records = mysqli_fetch_assoc($sel);
$totalRecords = $records['allcount'];

## Total number of record with filtering
$sel = mysqli_query($connection, "SELECT count(*) AS allcount FROM user WHERE 1 " . $searchQuery);
$records = mysqli_fetch_assoc($sel);
$totalRecordwithFilter = $records['allcount'];

## Fetch records
$empQuery = "SELECT * FROM user WHERE 1 " . $searchQuery . " ORDER BY " . $columnName . " " . $columnSortOrder . " LIMIT " . $row . "," . $rowperpage;
$empRecords = mysqli_query($connection, $empQuery);

$data = array();

while ($row = mysqli_fetch_assoc($empRecords)) {
    $mofidybutton = "<button class='btn btn-warning modifyUser' type='button' data-toggle='modal' data-target='#modifyModal' value='" . $row['userId'] . "'><i class='fa fa-edit'></i></button>";
    $action = $mofidybutton;

    
    $data[] = array(
    "name" => $row['name'],
    "lastname" => $row['lastname'],
    "phone" => $row['phone'],
    "email" => $row['email'],
    "action" =>  $action

  );
}

## Response
$response = array(
  "draw" => intval($draw),
  "iTotalRecords" => $totalRecords,
  "iTotalDisplayRecords" => $totalRecordwithFilter,
  "aaData" => $data
);

echo json_encode($response);