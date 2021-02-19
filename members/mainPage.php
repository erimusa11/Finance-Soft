<?php
registerInvoice();
global $connection;
$query = 'SELECT productId, productName, productUnit, productPriceSold
FROM product';
$result = mysqli_query($connection, $query);
$userId = $_SESSION['user_id'];

//query get sum amount today's sales
$queryTodaySales = "SELECT
(SELECT COALESCE(SUM(orders.totalAmount), 0)
FROM orders
WHERE DATE(orders.orderDate) = CURDATE()
AND orders.userId = '$userId'
) totalAmount,
(SELECT COALESCE(SUM(order_items.product_unit),0)
FROM order_items
INNER JOIN orders
ON order_items.order_id = orders.orderId
AND order_items.user_id = '$userId'
AND DATE(orders.orderDate) = CURDATE()
) totalProductUnit";

$resultTodaySales = mysqli_query($connection, $queryTodaySales);
$rowTodaySales = mysqli_fetch_assoc($resultTodaySales);
$todayTotalAmount = $rowTodaySales['totalAmount'];
$todayTotalProduct = $rowTodaySales['totalProductUnit'];

//query get sum amount last/current week, last/current month
$queryWeekSales = "SELECT(
    SELECT COALESCE(SUM(totalAmount), 0)
    FROM orders
    WHERE WEEKOFYEAR(orderDate)=WEEKOFYEAR(CURDATE())-1
    AND userId = '$userId'
    ) lastWeekAmount,
    (
    SELECT COALESCE(SUM(totalAmount), 0) AS t1
    FROM orders
    WHERE WEEKOFYEAR(orderDate)=WEEKOFYEAR(CURDATE())
    AND userId = '$userId'
    ) currentWeekAmount,
    (
    SELECT COALESCE(SUM(totalAmount), 0) AS t1
    FROM orders
    WHERE MONTH(orderDate)=MONTH(CURDATE())-1
    AND userId = '$userId'
    ) lastMonthAmount,
    (
    SELECT COALESCE(SUM(totalAmount), 0) AS t1
    FROM orders
    WHERE MONTH(orderDate)=MONTH(CURDATE())
    AND userId = '$userId'
    ) currentMonthAmount
    ";
$resultWeekSales = mysqli_query($connection, $queryWeekSales);
$rowWeekSales = mysqli_fetch_assoc($resultWeekSales);
$lastWeekAmount = $rowWeekSales['lastWeekAmount'];
$currentWeekAmount = $rowWeekSales['currentWeekAmount'];
$lastMonthAmount = $rowWeekSales['lastMonthAmount'];
$currentMonthAmount = $rowWeekSales['currentMonthAmount'];

if ($lastWeekAmount > $currentWeekAmount) {
    $weekIcon = '<i class="font-danger" data-feather="arrow-down"></i>';
} elseif ($lastWeekAmount < $currentWeekAmount) {
    $weekIcon = '<i class="font-primary" data-feather="arrow-up"></i>';
} else {
    $weekIcon = '<img src="../../assets/images/equal.svg" width="35px" height="35px">';
}

if ($lastMonthAmount > $currentMonthAmount) {
    $monthIcon = '<i class="font-danger" data-feather="arrow-down"></i>';
} elseif ($lastMonthAmount < $currentMonthAmount) {
    $monthIcon = '<i class="font-primary" data-feather="arrow-up"></i>';
} else {
    $monthIcon = '<img src="../../assets/images/equal.svg" width="35px" height="35px" />';
}

$weekTemplate = '<div class="media-body align-self-center">' . $weekIcon . '</div>
<div class="media-body">
    <h6 class="mb-0"><label style="font-size: 12px">LEK</label> <span class="counter">' . $currentWeekAmount . '</span></h6>
    <span class="mb-1"><span style="font-size: 12px">LEK</span> ' . $lastWeekAmount . '</span>
</div>';

$monthTemplate = '<div class="media-body align-self-center">' . $monthIcon . '</div>
<div class="media-body">
    <h6 class="mb-0"><label style="font-size: 12px">LEK</label> <span class="counter">' . $currentMonthAmount . '</span></h6>
    <span class="mb-1"><span style="font-size: 12px">LEK</span> ' . $lastMonthAmount . '</span>
</div>';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include '../cssLinks.php';?>
    <title>Kryefaqja</title>
    <style></style>
</head>

<body>
    <!-- tap on top starts-->
    <div class="tap-top"><i data-feather="chevrons-up"></i></div>
    <!-- tap on tap ends-->
    <!-- page-wrapper Start-->
    <div class="page-wrapper" id="pageWrapper">
        <!-- Page Header Start-->
        <?php include '../topMenu.php';?>
        <!-- Page Header Ends
                              -->
        <!-- Page Body Start-->

        <!-- Page Sidebar Start-->
        <div class="page-body-wrapper">
            <!-- Page Sidebar Ends-->
            <div class="page-body">
                <?php if (!empty($_SESSION['expirationDate'])) {
    echo $_SESSION['expirationDate'];
}?>
                <!-- Container-fluid starts-->
                <div class="container-fluid">
                    <div class="row p-t-10">
                        <div class="col-sm-6 col-xl-3 col-lg-6">
                            <div class="card o-hidden">
                                <div class="bg-primary b-r-4 card-body">
                                    <div class="media static-top-widget">
                                        <div class="align-self-center text-center"><i class="fa fa-money"
                                                style="font-size: 30px"></i>
                                        </div>
                                        <div class="media-body"><span class="m-0">Të ardhurat Sot (Lek)</span>
                                            <h4 class="mb-0 counter"><?php echo $todayTotalAmount; ?></h4>
                                            <div class="icon-bg"><i class="fa fa-money" style="font-size: 100px"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xl-3 col-lg-6">
                            <div class="card o-hidden">
                                <div class="bg-secondary b-r-4 card-body">
                                    <div class="media static-top-widget">
                                        <div class="align-self-center text-center"><i data-feather="shopping-bag"></i>
                                        </div>
                                        <div class="media-body"><span class="m-0">Produktet e shitura Sot</span>
                                            <h4 class="mb-0 counter"><?php echo $todayTotalProduct; ?></h4><i
                                                class="icon-bg" data-feather="shopping-bag"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-6 col-md-6 col-sm-12  mt-3">
                            <div class="widget-joins card widget-arrow widget-joins-custom  ">
                                <div class="row">
                                    <div class="col-sm-12 pr-0">
                                        <div class="media border-after-xs">
                                            <div class="align-self-center mr-5 text-left">
                                                <h6 class="mb-1">Të ardhurat</h6>
                                                <h5 class="mb-0">Javore</h5>
                                            </div>
                                            <?php echo $weekTemplate; ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 pr-0">
                                        <div class="media">
                                            <div class="align-self-center mr-5 text-left">
                                                <h6 class="mb-1">Të ardhurat</h6>
                                                <h5 class="mb-0">Mujore</h5>
                                            </div>
                                            <?php echo $monthTemplate; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row pt-3">
                        <div class="col-sm-12 col-xl-5 col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-md-6 mb-2">
                                            <h5>Produktet</h5>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-row">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text"><i class="fa fa-search"></i>
                                                        </div>
                                                    </div>
                                                    <input type="search" class="form-control" id="search"
                                                        placeholder="Kërko">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="card-body megaoptions-border-space-sm vertical-scroll scroll-demo-vertical">
                                    <form class="border-style">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="row  p-r-20 p-l-20 p-b-20">
                                                    <div class="col-8">
                                                        Titulli i produktit
                                                    </div>
                                                    <div class="col-2">
                                                        <span
                                                            class="badge badge-primary pull-right digits">Gjendja</span>
                                                    </div>

                                                    <div class="col-2">
                                                        <span class="badge badge-info pull-right digits">Cmimi</span>
                                                    </div>
                                                </div>
                                                <div id="productList">
                                                    <?php while ($row = mysqli_fetch_array($result)) {
    $productId = $row['productId'];
    $productName = $row['productName'];
    $productUnit = $row['productUnit'];
    if ($productUnit == 0) {
        $classDisabled = 'disabled';
    } else {
        $classDisabled = '';
    }
    $productPriceSold = $row['productPriceSold'];?>
                                                    <div
                                                        class="card ripple productList <?php echo $classDisabled . ' ' . $productId; ?>">
                                                        <div class="media p-20">
                                                            <div class="media-body">
                                                                <h6 class="mt-0 mega-title-badge">
                                                                    <div class="row">
                                                                        <input class="form-control productId"
                                                                            value="<?php echo $productId; ?>" hidden
                                                                            readonly />
                                                                        <div class="col-8 productName">
                                                                            <?php echo $productName; ?>
                                                                        </div>
                                                                        <div class="col-2">
                                                                            <span
                                                                                class="badge badge-primary pull-right digits productUnit"><?php echo $productUnit; ?></span>
                                                                        </div>
                                                                        <div class="col-2">
                                                                            <span
                                                                                class="badge badge-info pull-right digits productPrice"><?php echo $productPriceSold; ?></span>
                                                                        </div>
                                                                    </div>
                                                                </h6>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
}?>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 col-lg-12 col-xl-7">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Fatura</h5>
                                </div>
                                <form action="" method="POST">
                                    <div class="card-body  invoiceBlocUi vertical-scroll scroll-demo-vertical">
                                        <input type="text" value="<?php echo $userId; ?>" name="userId"
                                            class="form-control costum-input" readonly hidden />
                                        <div class="table-responsive horizontal-scroll scroll-demo-horizontal">
                                            <table class="table table-bordered ">
                                                <thead class="table-primary">
                                                    <tr>
                                                        <th>Emri i produktit</th>
                                                        <th>Çmimi (Lek)</th>
                                                        <th>Sasia</th>
                                                        <th>Totali (Lek)</th>
                                                        <th>Veprimi</th>
                                                    </tr>
                                                </thead>
                                                <form>
                                                    <tbody id="productTable">
                                                        <tr class="text-center no-data-table">
                                                            <td colspan="5">Nuk ka të dhëna të rregjistruara</td>
                                                        </tr>
                                                    </tbody>
                                                    <tfoot>

                                                    </tfoot>

                                                </form>
                                            </table>
                                            <div class="row ml-2 mt-4">
                                                <div class="col-md-6 col-6">
                                                    <h6 class="m-0"> <span class="f-w-600">Cmimi Total:</span>
                                                    </h6>
                                                </div>
                                                <div class="col-md-6 col-6 ">
                                                    <div class="input-group mb-3 d-flex justify-content-end">
                                                        <input class="form-control costum-input totalPriceInvoice"
                                                            name="totalPriceInvoice" type="text" value="0.00" readonly>
                                                        <div class="input-group-append"><span
                                                                class="input-group-text">Lek</span></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <button class="btn btn-success cart-btn-transform" type="submit"
                                                name="save">Rregjistro</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Container-fluid Ends-->
            </div>
            <!-- footer start-->
            <?php include '../footer.php';?>
        </div>
    </div>
    <?php include '../jsLinks.php';
if (!empty($responseInvoice)) {
    echo $responseInvoice;
}

?>
    <script src="../../assets/pages/invoice.js"></script>
</body>

</html>