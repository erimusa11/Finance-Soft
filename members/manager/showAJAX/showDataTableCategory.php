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
    $searchQuery = " and (category like '%".$searchValue."%') ";
}

## Total number of records without filtering
$sel = mysqli_query($connection, "select count(*) as allcount from product_category");
$records = mysqli_fetch_assoc($sel);
$totalRecords = $records['allcount'];

## Total number of record with filtering
$sel = mysqli_query($connection, "SELECT count(*) AS allcount FROM product_category WHERE 1 ".$searchQuery);
$records = mysqli_fetch_assoc($sel);
$totalRecordwithFilter = $records['allcount'];



## Fetch records
$empQuery = "SELECT * FROM product_category WHERE 1 ".$searchQuery." ORDER BY ".$columnName." ".$columnSortOrder." LIMIT ".$row.",".$rowperpage;
$empRecords = mysqli_query($connection, $empQuery);
$data = array();



while ($row = mysqli_fetch_assoc($empRecords)) {

     // Update Button
    $updateButton = "
     <div class='row'>   
     <div class='col-5'>
     <button type='button' id='updateCategory' class='btn btn-sm btn-info updateCategory' dataId='".$row['id_category']."' data-toggle='modal' val='".$row['category']."' data-target='#updateModalCategory' ><i class='fa fa-edit'></i></button> </div>";

  
    $action = $updateButton;
   

    $data[] = array(
      "id_category"=>$row['id_category'],
      "category"=>$row['category'],
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