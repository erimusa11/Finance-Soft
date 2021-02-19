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

if ($columnName == 'id_category') {
    $columnName = 'product_category.category';
} elseif ($columnName == 'userId') {
    $columnName = 'user.name';
} elseif ($columnName == 'supplierId') {
    $columnName = 'supplier.supplierName';
} elseif ($columnName == 'expiration_date') {
    $columnName = 'product.expiration_date';
}
## Search
$searchQuery = " ";
if ($searchValue != '') {
    $searchQuery = " and (productName like '%" . $searchValue . "%' or 
    productUnit like '%" . $searchValue . "%' or 
   productPriceBought like'%" . $searchValue . "%' or 
   productPriceSold like'%" . $searchValue . "%' or 
   product.expiration_date like'%" . $searchValue . "%' or
   product.expiration_date like'%" .date('Y-m-d', strtotime($searchValue)) . "%' or  
  CONCAT(DAY(product.expiration_date),'-', MONTH(product.expiration_date)) like'%" .$searchValue. "%' or  
  DAY(product.expiration_date) like'%". $searchValue . "%' or  
  MONTH(product.expiration_date) like'%" .$searchValue. "%' or  
  YEAR(product.expiration_date) like'%" .$searchValue . "%' or  
   fiscal_code like'%" . $searchValue . "%' or 
   user.name like'%" . $searchValue . "%' or 
   user.lastname like'%" . $searchValue . "%' or 
   product_category.category like'%" . $searchValue . "%' or 
   supplier.supplierName like'%" . $searchValue . "%') ";
}


## Total number of records without filtering
$sel = mysqli_query($connection, "select count(*) as allcount  from product , product_category , supplier , user
where product.id_category = product_category.id_category
 AND product.supplierId = supplier.supplierId
 AND product.userId =user.userId");
$records = mysqli_fetch_assoc($sel);
$totalRecords = $records['allcount'];

## Total number of record with filtering
$sel = mysqli_query($connection, "SELECT count(*) AS allcount  from product , product_category , supplier , user
 WHERE 1 " . $searchQuery ." and product.id_category = product_category.id_category
 AND product.supplierId = supplier.supplierId
 AND product.userId =user.userId");
$records = mysqli_fetch_assoc($sel);
$totalRecordwithFilter = $records['allcount'];



## Fetch records
$empQuery = "SELECT *,product.expiration_date from product , product_category , supplier , user
 WHERE 1 " . $searchQuery . " AND product.id_category = product_category.id_category
 AND product.supplierId = supplier.supplierId
 AND product.userId =user.userId ORDER BY ".$columnName." ".$columnSortOrder." LIMIT " . $row . "," . $rowperpage;
$empRecords = mysqli_query($connection, $empQuery);
$data = array();



while ($row = mysqli_fetch_assoc($empRecords)) {
    $supplier = $row['supplierName'];
    $useid = $row['userId'];
    $fiscal_code = $row['fiscal_code'];
    $category = $row['category'];
    $name_user = $row['name'];
    $lastname_user = $row['lastname'];
    $fullname = $name_user . " " . $lastname_user;

    $expire_date = date("d-m-Y", strtotime($row['expiration_date']));
    // Update Button
    $updateButton = "
     <div class='row'>   
     <div class='col-6'>
     <button type='button' id='updateUser' class='btn btn-sm btn-info updateUser' data-id='" . $row['productId'] . "'   dataId='" . $row['productId'] . "' data-toggle='modal' val='" . $row['productName'] . "' atrib='" . $row['productUnit'] . "' values='" . $row['productPriceBought'] . "' value1='" . $row['productPriceSold'] . "' value5='" . $expire_date . "' value3='" . $fullname . "' value4='" . $fiscal_code . "' data-target='#updateModal' ><i class='fa fa-edit'></i></button> </div>";

    $action = $updateButton;


    $data[] = array(

    "productName" => $row['productName'],
    "productUnit" => $row['productUnit'],
    "productPriceBought" => $row['productPriceBought'],
    "productPriceSold" => $row['productPriceSold'],
    "expiration_date" => $expire_date,
    "id_category" => $category,
    "userId" => $fullname,
    "supplierId" => $supplier,
    "fiscal_code" => $fiscal_code,
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