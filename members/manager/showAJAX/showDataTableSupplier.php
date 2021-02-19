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
    $searchQuery = " and (supplierName like '%".$searchValue."%' or 
   supplierEmail like '%".$searchValue."%' or 
   supplierPhone like'%".$searchValue."%') ";
}

## Total number of records without filtering
$sel = mysqli_query($connection, "select count(*) as allcount from supplier");
$records = mysqli_fetch_assoc($sel);
$totalRecords = $records['allcount'];

## Total number of record with filtering
$sel = mysqli_query($connection, "SELECT count(*) AS allcount FROM supplier WHERE 1 ".$searchQuery);
$records = mysqli_fetch_assoc($sel);
$totalRecordwithFilter = $records['allcount'];

## Fetch records
$empQuery = "SELECT * FROM supplier WHERE 1 ".$searchQuery." ORDER BY ".$columnName." ".$columnSortOrder." LIMIT ".$row.",".$rowperpage;
$empRecords = mysqli_query($connection, $empQuery);
$data = array();



while ($row = mysqli_fetch_assoc($empRecords)) {

     // Update Button
    $updateButton = "<button type='button' id='updateUser' class='btn btn-sm btn-info updateUser ' dataId='".$row['supplierId']."' data-toggle='modal' val='".$row['supplierName']."' atrib='".$row['supplierEmail']."' values='".$row['supplierPhone']."' data-target='#updateModal' ><i class='fa fa-edit'></i></button>";

    // Delete Button
    $deleteButton = "<button type='button'  class='btn btn-sm btn-danger deleteUser' data-target='#deleteModal' data-toggle='modal' dataid='".$row['supplierId']."'><i class='fa fa-trash-o'></i></button>";
    $action = $updateButton." ".$deleteButton;


    $data[] = array(
      "supplierId"=>$row['supplierId'],
      "supplierName"=>$row['supplierName'],
      "supplierEmail"=>$row['supplierEmail'],
      "supplierPhone"=>$row['supplierPhone'],
      "action" => $action
     
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