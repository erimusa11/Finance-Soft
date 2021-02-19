<?php
global $connection;

$query = "SELECT orders.*,
order_items.product_id, order_items.product_unit, order_items.product_price,
product.productName, product.fiscal_code, product.productPriceSold,
CONCAT(user.name, ' ', user.lastname) AS fullName,
user.phone, user.email
FROM orders
INNER JOIN order_items
ON order_items.order_id = orders.orderId
INNER JOIN user
ON user.userId = orders.userId
INNER JOIN product
ON product.productId = order_items.product_id
AND orders.orderId = '$id_order'";
$result = mysqli_query($connection, $query);
$nrRow = 0;
$tableRow = '';

while ($row = mysqli_fetch_array($result)) {
    ++$nrRow;

    $sellerEmail = $row['email'];
    $sellerPhone = $row['phone'];
    $sellerName = $row['fullName'];
    $invoiceNr = $row['orderDateTimeStamp'];
    $invoiceDate = date('d-m-Y H:i:s', strtotime($row['orderDate']));

    $productFiscalCode = $row['fiscal_code'];
    $productName = $row['productName'];
    $productUnitBought = $row['product_unit'];
    $productPriceSold = $row['productPriceSold'];
    $productAmount = $row['product_price'];
    $invoiceTotalAmount = $row['totalAmount'];

    $tableRow .= '       <tr>
    <td>
        <span class="p-2 mb-0">' . $nrRow . '</span>
    </td>
    <td>
        <span class="p-2 mb-0">' . $productFiscalCode . '</span>
    </td>
    <td>
        <span class="p-2 mb-0">' . $productName . '</span>
    </td>
    <td>
        <span class="p-2 mb-0">' . $productUnitBought . '</span>
    </td>
    <td>
        <span class="p-2 mb-0">' . $productPriceSold . '</span>
    </td>
    <td>
        <span class="p-2 mb-0">' . $productAmount . '</span>
    </td>
</tr>';
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include '../cssLinks.php';?>
</head>
<style>
@media print {
    table td:nth-child(2) {
        display: none
    }

    table th:nth-child(2) {
        display: none
    }
}
</style>

<body>
    <!-- tap on top starts-->

    <!-- tap on tap ends-->
    <!-- page-wrapper Start-->
    <div class="col-sm-12">
        <div class="card" id="print_zone">
            <div class="card-body">
                <div>
                    <div>
                        <div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="media">
                                        <div class="media-left"><img class="media-object img-60"
                                                src="../../assets/images/other-images/logo-login.png" alt=""></div>
                                        <div class="media-body m-l-20">
                                            <h4 class="media-heading">Logo</h4>
                                            <p><?php echo $sellerEmail; ?><br><span
                                                    class="digits"><?php echo $sellerPhone; ?></span></p>
                                        </div>
                                    </div>
                                    <!-- End Info-->
                                </div>
                                <div class="col-sm-6">
                                    <div class="text-md-right">
                                        <h3>Fature #<span class="digits counter"><?php echo $invoiceNr; ?></span>
                                        </h3>
                                        <p>Data regjistrimit: <?php echo $invoiceDate; ?>
                                        </p>
                                        <p>Perdoruesi : <?php echo $sellerName; ?> </p>
                                    </div>
                                    <!-- End Title-->
                                </div Matching Tag>
                            </div>
                        </div>
                        <hr>
                        <!-- End InvoiceTop-->

                        <!-- End Invoice Mid-->
                        <div>
                            <div class="table-responsive invoice-table" id="table">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <td class="code">
                                                <h6 class="p-2 mb-0">Nr.</h6>
                                            </td>
                                            <td class="code">
                                                <h6 class="p-2 mb-0">Kodi fiskal</h6>
                                            </td>
                                            <td class="item">
                                                <h6 class="p-2 mb-0">Produktet</h6>
                                            </td>
                                            <td class="Hours">
                                                <h6 class="p-2 mb-0">Sasia</h6>
                                            </td>
                                            <td class="Rate">
                                                <h6 class="p-2 mb-0">Cmimi</h6>
                                            </td>
                                            <td class="subtotal">
                                                <h6 class="p-2 mb-0">Nën-total</h6>
                                            </td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php echo $tableRow; ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="4"></td>
                                            <td class="Rate">
                                                <h6 class="mb-0 p-2">Total</h6>
                                            </td>
                                            <td class="payment digits">
                                                <h6 class="mb-0 p-2">Lek <?php echo $invoiceTotalAmount; ?></h6>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <!-- End Table-->

                        </div>
                        <!-- End InvoiceBot-->
                    </div>

                    <!-- End Invoice-->
                    <!-- End Invoice Holder-->
                </div>
            </div>
        </div>
    </div>



    </div>
    <div class="col-sm-12 text-center mt-3">
        <button class="btn btn btn-primary mr-2" type="button" onclick="printMe()">Print</button>
        <button class="btn btn btn-danger mr-2" type="button" onclick="goBack()">Mbyll</button>
    </div>
    <!-- latest jquery-->
    <?php include '../jsLinks.php';?>
    <script src="../../assets/js/print.js"></script>
</body>
<script>
"use strict";

function printMe() {
    $('body').css('visibility', 'hidden');
    $('#print_zone').css('visibility', 'visible');
    window.print();
}

function goBack() {
    window.location.href = "index.php";
}
</script>

</html>