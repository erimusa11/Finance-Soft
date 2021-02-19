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

if ($columnName == 'userId') {
    $columnName = 'user.name';
}
if ($columnName == 'supplierId') {
    $columnName = 'supplier.supplierName';
}


$searchByFromdate = $_POST['searchByFromdate'];
$searchByFromdate1 = date('Y-m-d', strtotime($searchByFromdate));
$searchByTodate = $_POST['searchByTodate'];
$searchByTodate1 = date('Y-m-d', strtotime($searchByTodate));


## Search
$searchQuery = " ";
if ($searchValue != '') {
    $searchQuery = " and (product.productName like '%" . $searchValue . "%' or 
    product_history.productUnitOld like '%" . $searchValue . "%' or 
    product_history.productUnitNew like'%" . $searchValue . "%' or 
    product_history. productPriceBoughtOld like'%" . $searchValue . "%' or 
    product_history.productPriceBoughtNew like'%" . $searchValue . "%' or  
    product_history.productPriceSalesOld like'%" . $searchValue . "%' or 
    product_history.productPriceSalesNew like'%" . $searchValue . "%' or 
    date_supply like'%" .date('Y-m-d', strtotime($searchValue)) . "%' or  
    CONCAT(DAY(date_supply),'-', MONTH(date_supply)) like'%" .$searchValue. "%' or  
    DAY(date_supply) like'%". $searchValue . "%' or  
    MONTH(date_supply) like'%" .$searchValue. "%' or  
    YEAR(date_supply) like'%" .$searchValue . "%' or
   user.name like'%" . $searchValue . "%' or 
   user.lastname like'%" . $searchValue . "%' or 
   supplier.supplierName like'%" . $searchValue . "%'  or 
   supplier.supplierName like'%" . $searchValue . "%') ";
}

if ($searchByFromdate != '' && $searchByTodate != '') {
    $searchQuery .= " and (date_supply between '" . $searchByFromdate1 . "' and '" . $searchByTodate1 . "' ) ";
}
## Total number of records without filtering
$sel = mysqli_query($connection, "select count(*) as allcount from product JOIN product_history ON product.productId = product_history.productId JOIN supplier ON product.supplierId = supplier.supplierId JOIN user ON product.userId = user.userId");
$records = mysqli_fetch_assoc($sel);
$totalRecords = $records['allcount'];

## Total number of record with filtering
$sel = mysqli_query($connection, "SELECT count(*) AS allcount FROM product JOIN product_history ON product.productId = product_history.productId JOIN supplier ON product.supplierId = supplier.supplierId JOIN user ON product.userId = user.userId WHERE 1 " . $searchQuery);
$records = mysqli_fetch_assoc($sel);
$totalRecordwithFilter = $records['allcount'];



## Fetch records
$empQuery = "SELECT * FROM product JOIN product_history ON product.productId = product_history.productId JOIN supplier ON product.supplierId = supplier.supplierId JOIN user ON product.userId = user.userId WHERE 1 " . $searchQuery . " ORDER BY " . $columnName . " " . $columnSortOrder . " LIMIT " . $row . "," . $rowperpage;
$empRecords = mysqli_query($connection, $empQuery);
$data = array();



while ($row = mysqli_fetch_assoc($empRecords)) {
    $supplier = $row['supplierName'];
    $useid = $row['userId'];
 


    $name_user = $row['name'];
    $lastname_user = $row['lastname'];
    $fullname = $name_user . " " . $lastname_user;

    $expire_date = date("d-m-Y", strtotime($row['expiration_date']));
    // Update Button
    $updateButton = "
     <div class='row'>   
     <div class='col-6'>
     <button type='button' id='updateUser' class='btn btn-sm btn-info updateUser' dataId='" . $row['productId'] . "' data-toggle='modal' val='" . $row['productName'] . "' atrib='" . $row['productUnit'] . "' values='" . $row['productPriceBought'] . "' value1='" . $row['productPriceSold'] . "' value2='" . $expire_date . "' value3='" . $fullname . "' value4='" . $fiscal_code . "' data-target='#updateModal' ><i class='fa fa-edit'></i></button> </div>";


    $action = $updateButton;

    $data_supply = date("d-m-Y H:i:s", strtotime($row['date_supply']));
    $data[] = array(
        
    "productName" => $row['productName'],
    "productUnitOld" => $row['productUnitOld'],
    "productUnitNew" => $row['productUnitNew'],
    "productPriceBoughtOld" => $row['productPriceBoughtOld'],
    "productPriceBoughtNew" => $row['productPriceBoughtNew'],
    "productPriceSalesOld" => $row['productPriceSalesOld'],
    "productPriceSalesNew" => $row['productPriceSalesNew'],
    "date_supply" => $data_supply,
    "userId" => $fullname,
    "supplierId" => $supplier,

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