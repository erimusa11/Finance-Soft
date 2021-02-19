<?php

include '../functions.php';
global $connection;
$productId = $_POST['productId'];
$productUnitToBuy = $_POST['productUnitToBuy'];

$productTotalPrice = 0;
$data = [];
$queryStock = "SELECT productUnit, productPriceSold
FROM product
WHERE productId = '$productId'";
$resultStock = mysqli_query($connection, $queryStock);
$rowStock = mysqli_fetch_assoc($resultStock);
$productUnitStock = $rowStock['productUnit'];
$productPrice = $rowStock['productPriceSold'];

if ($productUnitToBuy > $productUnitStock) {
    echo 'outOfStock';
} else {
    $productTotalPrice = round($productUnitToBuy * $productPrice, 2);
    $newProductUnitStock = $productUnitStock - $productUnitToBuy;
    $data[] = [
        'unitToBuy' => $productUnitToBuy,
        'unitStock' => $productUnitStock,
        'newUnitStock' => $newProductUnitStock,
        'totalPrice' => $productTotalPrice,
    ];

    echo json_encode($data);
}