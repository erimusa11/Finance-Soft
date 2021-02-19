<?php

session_start();
include '../../../functions.php';
## Read value
$draw = $_POST['draw'];
$row = $_POST['start'];
$rowperpage = $_POST['length']; // Rows display per page
$columnIndex = $_POST['order'][0]['column']; // Column index
$columnName = $_POST['columns'][$columnIndex]['data']; // Column name
$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
$searchValue = mysqli_real_escape_string($connection, $_POST['search']['value']); // Search value

if ($columnName == 'userId') {
    $columnName = 'user.name';
}
## Date search value
$searchByFromdate = $_POST['searchByFromdate'];
$searchByFromdate1 = date('Y-m-d', strtotime($searchByFromdate));
$searchByTodate = $_POST['searchByTodate'];
$searchByTodate1 = date('Y-m-d', strtotime($searchByTodate));


## Search
$searchQuery = " ";
if ($searchValue != '') {
    $searchQuery = " and (orders.orderDateTimeStamp like '%" . $searchValue . "%' or
    orders.totalAmount like '%" . $searchValue . "%' or
    user.name like '%" . $searchValue . "%' or
    user.lastname like '%" . $searchValue . "%' or
    CONCAT(user.name,' ',user.lastname) like '%" . $searchValue . "%' or
   CONCAT(DAY(orders.orderDate),'-', MONTH(orders.orderDate)) = '" . $searchValue . "' or  
   DAY(orders.orderDate) = '" . $searchValue . "' or  
   MONTH(orders.orderDate) = '" . $searchValue . "' or  
   YEAR(orders.orderDate) = '" . $searchValue . "') ";
}

// Date filter
if ($searchByFromdate != '' && $searchByTodate != '') {
    $searchQuery .= " and (cast(orderDate as DATE) between '" . $searchByFromdate1 . "' and '" . $searchByTodate1 . "' ) ";
}

## Total number of records without filtering
$sel = mysqli_query($connection, "select count(*) as allcount from orders, user WHERE orders.userId = user.userId");
$records = mysqli_fetch_assoc($sel);
$totalRecords = $records['allcount'];

## Total number of records with filtering
$sel = mysqli_query($connection, "select count(*) as allcount from orders , user WHERE 1 " . $searchQuery . " AND  orders.userId =user.userId");
$records = mysqli_fetch_assoc($sel);
$totalRecordwithFilter = $records['allcount'];

## Fetch records
$empQuery = "SELECT * FROM orders ,user   WHERE 1 " . $searchQuery . " AND orders.userId =user.userId ORDER BY " . $columnName . " " . $columnSortOrder . " LIMIT " . $row . "," . $rowperpage;
$empRecords = mysqli_query($connection, $empQuery);
$data = array();

while ($row = mysqli_fetch_assoc($empRecords)) {
    $name_user = $row['name'];
    $lastname_user = $row['lastname'];
    $fullname = $name_user . " " . $lastname_user;

    $action = '<a href="orders_item_total.php?nr=' . $row['orderId'] . '" target="_blank"  class="btn btn-primary btn-sm " role="button" aria-pressed="true"><i class="fa fa-external-link"></i> Kliko</a>';

    $orderDate = date("d-m-Y H:i:s", strtotime($row['orderDate']));

    $data[] = array(
        "orderDateTimeStamp" => $row['orderDateTimeStamp'],
        "totalAmount" => $row['totalAmount'],
        "orderDate" => $orderDate,
        "userId" => $fullname,
        "action" => $action,
    );
}

## Response
$response = array(
    "draw" => intval($draw),
    "iTotalRecords" => $totalRecords,
    "iTotalDisplayRecords" => $totalRecordwithFilter,
    "aaData" => $data,
);

echo json_encode($response);
