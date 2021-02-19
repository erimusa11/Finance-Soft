<?php

session_start();
include '../../../dbconnection.php';
$id_user = $_SESSION['user_id'];
//# Read value
$draw = $_POST['draw'];
$row = $_POST['start'];
$rowperpage = $_POST['length']; // Rows display per page
$columnIndex = $_POST['order'][0]['column']; // Column index
$columnName = $_POST['columns'][$columnIndex]['data']; // Column name
$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
$searchValue = mysqli_real_escape_string($connection, $_POST['search']['value']); // Search value

//# Date search value
$searchByFromdate = $_POST['searchByFromdate'];
$searchByFromdate1 = date('Y-m-d', strtotime($searchByFromdate));
$searchByTodate = $_POST['searchByTodate'];
$searchByTodate1 = date('Y-m-d', strtotime($searchByTodate));

//# Search
$searchQuery = ' ';
if ($searchValue != '') {
    $searchQuery = " and (orderDateTimeStamp like '%".$searchValue."%' or
    totalAmount like '%".$searchValue."%' or
    orderDate like'%".$searchValue."%') ";
}

// Date filter
if ($searchByFromdate != '' && $searchByTodate != '') {
    $searchQuery .= " and (orderDate between '".$searchByFromdate1."' and '".$searchByTodate1."' ) ";
}

//# Total number of records without filtering
$sel = mysqli_query($connection, "select count(*) as allcount from orders where userId='$id_user'");
$records = mysqli_fetch_assoc($sel);
$totalRecords = $records['allcount'];

//# Total number of records with filtering
$sel = mysqli_query($connection, "select count(*) as allcount from orders  where userId='$id_user' and 1  ".$searchQuery);
$records = mysqli_fetch_assoc($sel);
$totalRecordwithFilter = $records['allcount'];

//# Fetch records
$empQuery = "SELECT * FROM orders  where userId='$id_user'  AND 1 ".$searchQuery.' order by '.$columnName.' '.$columnSortOrder.' limit '.$row.','.$rowperpage;
$empRecords = mysqli_query($connection, $empQuery);
$data = [];

while ($row = mysqli_fetch_assoc($empRecords)) {
    $name_user = $row['name'];
    $lastname_user = $row['lastname'];
  

    $action = '<a href="orders_item_total.php?nr='.$row['orderId'].'" target="_blank"  class="btn btn-primary btn-sm" role="button" aria-pressed="true"><i class="fa fa-external-link"></i> Kliko</a>';

    $orderDate = date('d-m-Y', strtotime($row['orderDate']));

    $data[] = [
        'orderDateTimeStamp' => $row['orderDateTimeStamp'],
        'totalAmount' => $row['totalAmount'],
        'orderDate' => $orderDate,
      
        'action' => $action,
    ];
}

//# Response
$response = [
    'draw' => intval($draw),
    'iTotalRecords' => $totalRecords,
    'iTotalDisplayRecords' => $totalRecordwithFilter,
    'aaData' => $data,
];

echo json_encode($response);