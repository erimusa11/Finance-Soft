<?php
include '../../functions.php';
ob_start();
session_start();
if (!isset($_SESSION['role']) || ($_SESSION['role'] == 2)) {
    header("Location: ../../index.php");
}
$id_user = $_SESSION['user_id'];
modifyProduct();
global $connection;
if (isset($_POST['save_products_update'])) {
    $productId = $_POST['productId'];
    $productUnitUpdate = $_POST['productUnitUpdate'];
    $productPriceBoughtUpdate = $_POST['productPriceBoughtUpdate'];
    $productPriceSoldUpdate = $_POST['productPriceSoldUpdate'];
    $expiration_dateUpdate = $_POST['expiration_dateUpdate'];
    $supplierIdUpdate = $_POST['supplierIdUpdate'];
    $today_date = date('Y-m-n H:i:s');
    //////////select actual data from table product /////
    $select_actual_product = "SELECT * FROM product WHERE productId='$productId'";
    $result_actual_product = mysqli_query($connection, $select_actual_product);
    $row_actual_product = mysqli_fetch_assoc($result_actual_product);
    $product_unit = $row_actual_product['productUnit'];
    $productPriceBought = $row_actual_product['productPriceBought'];
    $productPriceSold = $row_actual_product['productPriceSold'];
    /////insert values in table product_history before updating them/////
    $insert_into_product_his = "INSERT INTO product_history(productId,productUnitOld,productPriceBoughtOld,productPriceSalesOld) VALUES ('$productId','$product_unit','$productPriceBought','$productPriceSold')";
    $result_insert_product_his = mysqli_query($connection, $insert_into_product_his);
    $last_id = mysqli_insert_id($connection);
    if (!$result_insert_product_his) {
        echo("Error no insert data in product history: " . mysqli_error($connection));
    }
    /////////////////update table product with new data///////////
    $new_product_unit = $productUnitUpdate + $product_unit;
    $update_product_new_data = "UPDATE  product SET productUnit='$new_product_unit',productPriceBought='$productPriceBoughtUpdate',productPriceSold='$productPriceSoldUpdate' WHERE productId='$productId'";
    $result_updating = mysqli_query($connection, $update_product_new_data);
    if (!$result_updating) {
        echo("Error no updating data in table product: " . mysqli_error($connection));
    }
    //////////////////updating product_history with new data////////////
    $update_product_history = "UPDATE product_history SET productUnitNew='$new_product_unit',productPriceBoughtNew='$productPriceBoughtUpdate',productPriceSalesNew='$productPriceSoldUpdate',date_supply='$today_date',supplierId='$supplierIdUpdate',userId='$id_user' WHERE id_pro_his='$last_id'";
    $result_updating_product_his = mysqli_query($connection, $update_product_history);
    if (!$result_updating_product_his) {
        echo("Error no action: " . mysqli_error($connection));
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include '../cssLinks.php' ?>
    <title>Furnizim</title>
</head>
<style>
#btn {
    padding: 7px 7px;
    font-size: 16px;
    margin: 28px 20px;
}
</style>

<body>
    <!-- tap on top starts-->
    <div class="tap-top"><i data-feather="chevrons-up"></i></div>
    <!-- tap on tap ends-->
    <!-- Page Header Start-->
    <?php ?>
    <!-- Page Header Ends-->
    <!-- Page Body Start-->
    <div class="page-body-wrapper sidebar-icon" value=" horizontal-menu">
        <!-- Page Sidebar Start-->
        <?php include '../topMenu.php' ?>
        <!-- Page Sidebar Ends-->
        <div class="page-body">
            <!-- Container-fluid starts-->
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 mt-3">
                        <div class="card-header">
                            <h5 class="text-center">Furnizimet </h5>
                        </div>
                        <form class="card" action="update_products.php" method="POST">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <div class="d-flex justify-content-end">
                                                <button class="btn btn-info" type="button" data-toggle="modal"
                                                    data-target="#addProduct">Shto furnizim të
                                                    ri</button>
                                            </div>
                                            <br>
                                            <div class="table-responsive">
                                                <div class="row">
                                                    <div class="col-sm-2 mb-2">
                                                        <label for="">Data nga</label>
                                                        <input type="text" id="search_fromdate"
                                                            class="dateInput form-control">
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <label for="">Deri në</label>
                                                        <input type="text" id="search_todate"
                                                            class="dateInput form-control">
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <br>
                                                        <button type="button" id="btn_search"
                                                            class="btn btn-info mt-2">KËRKO</button>
                                                    </div>
                                                </div>
                                                <br>
                                                <table class="cell-border dataTable hover" id="table-supply">
                                                    <thead class="table-primary">
                                                        <tr>
                                                            <th>Emri i produktit</th>
                                                            <th>Sasia vjetër e produktit</th>
                                                            <th>Sasia e re e produktit</th>
                                                            <th>Cmimi vjetër i blerjes (lek)</th>
                                                            <th>Cmimi ri i blerjes (lek)</th>
                                                            <th>Cmimi vjetër i shitjes (lek)</th>
                                                            <th>Cmimi ri i shitjes (lek)</th>
                                                            <th>Data furnizimit</th>
                                                            <th>Përdoruesi</th>
                                                            <th>Furnitorët</th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-right">
                            </div>
                    </div>
                    <div class="modal fade" id="addProduct" tabindex="-1" role="dialog" aria-labelledby="addProduct"
                        aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Shto furnizim</h5>
                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span
                                            aria-hidden="true">×</span></button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group row">
                                        <div class="col-lg-4 col-form-label">
                                            <label>Produkti</label>
                                        </div>
                                        <div class="col-lg-6">
                                            <select name="productId" class="mySelect  form-control col-sm-12">
                                                <option></option>
                                                <?php $query_category = "SELECT * FROM product";
                                                $result_product = mysqli_query($connection, $query_category);
                                                while ($row_product = mysqli_fetch_array($result_product)) {
                                                    $productName = $row_product['productName'];
                                                    echo '<option value="' . $row_product['productId'] . '">' . $productName . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-lg-4 col-form-label">
                                            <label>Sasia e produktit</label>
                                        </div>
                                        <div class="col-lg-6">
                                            <input type="text" name="productUnitUpdate" class="form-control"
                                                placeholder="Sasia e produktit">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-lg-4 col-form-label">
                                            <label>Cmimi i blerjes</label>
                                        </div>
                                        <div class="col-lg-6">
                                            <input type="number" step="any" name="productPriceBoughtUpdate"
                                                class="form-control" placeholder="Cmimi i blerjes">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-lg-4 col-form-label">
                                            <label>Cmimi i shitjes</label>
                                        </div>
                                        <div class="col-lg-6">
                                            <input type="number" step="any" name="productPriceSoldUpdate"
                                                class="form-control" placeholder="Cmimi i shitjes">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-lg-4 col-form-label">
                                            <label>Furnitori</label>
                                        </div>
                                        <div class="col-lg-6">
                                            <select name="supplierIdUpdate"
                                                class="supplier_select col-sm-12 form-control"
                                                title="Zgjidhni Furnitorin">
                                                <?php $query_supplier = "SELECT * FROM supplier";
                                                $result_supplier = mysqli_query($connection, $query_supplier);
                                                while ($row_supplier = mysqli_fetch_array($result_supplier)) {
                                                    $id_supplier = $row_supplier['supplierId'];
                                                    $supplier = $row_supplier['supplierName'];
                                                    echo '<option value="' . $id_supplier . '">' . $supplier . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-primary" type="submit"
                                        name="save_products_update">Ruaj</button>
                                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Kthehu</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
            </form>
            <form class="card" action="" method="POST">
                <!-- Modal delete suppler-->
                <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModal"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Fshij produktin</h5>
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">×</span></button>
                            </div>
                            <div class="modal-body">
                                <h5 class="modal-title">Jeni te sigurte qe deshironi te kryeni kete veprim?
                                </h5>
                            </div>
                            <div class="modal-footer">
                                <input type="text" name="del_id" id="del_id" value="" hidden>
                                <button class="btn btn-primary" type="submit" name="delete_product">Fshij</button>
                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Kthehu</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!-- Container-fluid Ends-->
    </div>
    <!-- footer start-->
    <?php include '../footer.php' ?>
    </div>
    </div>
    <?php include '../jsLinks.php' ?>
    <script src="../../assets/pages/datepickerInit.js"></script>
    <!-- Plugin start-->
    <!-- footer start-->
    <?php
    ?> <?php
        if ($_SESSION['productExist'] == true) {
            echo '<script language="javascript">';
            echo 'swal("Gabim!", "Ky produkt ekziston!", "error")';
            echo '</script>';
        }
        if ($_SESSION['productCreated'] == true) {
            echo '<script language="javascript">';
            echo 'swal("Sukses!", "Produkti u krijua me sukses!", "success")';
            echo '</script>';
        }
        if ($_SESSION['updateProductSuccess'] == true) {
            echo '<script language="javascript">';
            echo 'swal("Sukses!", "Te dhenat u modifikuan me sukses!", "success")';
            echo '</script>';
        }
        if ($_SESSION['deleteProductSuccess'] == true) {
            echo '<script language="javascript">';
            echo 'swal("Sukses!", "Produkti u eliminua me sukses!", "success")';
            echo '</script>';
        }
        ?>
    <script>
    $(document).ready(function() {
        $('.mySelect').select2({
            dropdownParent: $("#addProduct"),
            width: '100%',
            'placeholder': 'Kërko'
        });
        $('.datepicker-here').datepicker({
            language: 'al',
        });
        var dataTable = $('#table-supply').DataTable({
            'processing': true,
            'serverSide': true,
            "lengthChange": false,
            'serverMethod': 'post',
            'ajax': {
                'url': 'showAJAX/showDatatableproduct_history.php',
                'data': function(data) {
                    // Read values
                    var from_date = $('#search_fromdate').val();
                    var to_date = $('#search_todate').val();
                    // Append to data
                    data.searchByFromdate = from_date;
                    data.searchByTodate = to_date;
                }
            },
            'columns': [{
                    data: 'productName'
                },
                {
                    data: 'productUnitOld'
                },
                {
                    data: 'productUnitNew'
                },
                {
                    data: 'productPriceBoughtOld'
                },
                {
                    data: 'productPriceBoughtNew'
                },
                {
                    data: 'productPriceSalesOld'
                },
                {
                    data: 'productPriceSalesNew'
                },
                {
                    data: 'date_supply'
                },
                {
                    data: 'userId'
                },
                {
                    data: 'supplierId'
                },
            ],
            dom: 'Bfrtip',
            buttons: [{
                    extend: 'print',
                    title: 'Furnizimet',
                    className: 'btn btn-primary mb-2',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9]
                    }
                },
                {
                    extend: 'excelHtml5',
                    title: 'Furnizimet',
                    className: 'btn btn-success mb-2',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9]
                    }
                },
                {
                    extend: 'pdfHtml5',
                    title: 'Furnizimet',
                    className: 'btn btn-danger mb-2',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9]
                    }
                },
            ]
        });

        // Search button
        $('#btn_search').click(function() {
            dataTable.draw();
        });

        $('body').on('click', '.deleteUser', function(e) {
            var dataid = $(this).attr('dataid');
            $('#del_id').val(dataid);
        });
        $('body').on('click', '.updateUser', function(e) {
            var id = $(this).attr('dataId');
            var productName = $(this).attr('val');
            var productUnit = $(this).attr('atrib');
            var productPriceBought = $(this).attr('values');
            var productPriceSold = $(this).attr('value1');
            var expiration_date = $(this).attr('value2');
            var fiscal_code = $(this).attr('value4');
            $('#txt_userid').val(id);
            $('#productName').val(productName);
            $('#productUnit').val(productUnit);
            $('#productPriceBought').val(productPriceBought);
            $('#productPriceSold').val(productPriceSold);
            $('#expiration_date').val(expiration_date);
            $('#fiscal_code').val(fiscal_code);
        });
    });
    </script>
</body>

</html>