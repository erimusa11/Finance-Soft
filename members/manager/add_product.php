<?php
include 'session.php';
AddProduct();
modifyProduct();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include '../cssLinks.php' ?>
    <title>Produktet</title>
</head>

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
                            <h5 class="text-center">Tabela produkteve </h5>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <div class="d-flex justify-content-end">
                                                <button class="btn btn-info" type="button" data-toggle="modal"
                                                    data-target="#exampleModalCenterSupplier">Shto Produkt</button>
                                            </div>
                                            <br>
                                            <div class="table-responsive">
                                                <table class="cell-border dataTable hover" id="example">
                                                    <thead class="table-primary">
                                                        <tr>
                                                            <th>Emri i produktit</th>
                                                            <th>Kodi fiskal</th>
                                                            <th>Sasia e produktit</th>
                                                            <th>Cmimi i blerjes</th>
                                                            <th>Cmimi i shitjes</th>
                                                            <th>Skadenca</th>
                                                            <th>Kategoria</th>
                                                            <th>Useri</th>
                                                            <th>furnitoret</th>
                                                            <th>Veprimet</th>
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
                        <!-- Modal create prod -->
                        <form action="add_product.php" method="POST">
                            <div class="modal fade" id="exampleModalCenterSupplier" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalCenterSupplier" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Shto Produkt</h5>
                                            <button class="close" type="button" data-dismiss="modal"
                                                aria-label="Close"><span aria-hidden="true">×</span></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group row">
                                                <div class="col-lg-4 col-form-label">
                                                    <label>Emri i produktit</label>
                                                </div>
                                                <div class="col-lg-8">
                                                    <input type="text" name="productName" class="form-control"
                                                        placeholder="Emri i produktit">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-lg-4 col-form-label">
                                                    <label>Kodi fiskal</label>
                                                </div>
                                                <div class="col-lg-8">
                                                    <input type="text" name="fiscal_code" class="form-control"
                                                        placeholder="Kodi fiskal">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-lg-4 col-form-label">
                                                    <label>Sasia e produktit</label>
                                                </div>
                                                <div class="col-lg-8">
                                                    <input type="text" name="productUnit" class="form-control"
                                                        placeholder="Sasia e produktit">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-lg-4 col-form-label">
                                                    <label>Cmimi i blerjes</label>
                                                </div>
                                                <div class="col-lg-8">
                                                    <input type="number" step="any" name="productPriceBought"
                                                        class="form-control" placeholder="Cmimi i blerjes">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-lg-4 col-form-label">
                                                    <label>Cmimi i shitjes</label>
                                                </div>
                                                <div class="col-lg-8">
                                                    <input type="number" step="any" name="productPriceSold"
                                                        class="form-control" placeholder="Cmimi i shitjes">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-lg-4 col-form-label">
                                                    <label>Data e skadences</label>
                                                </div>
                                                <div class="col-lg-8">
                                                    <input class="dateInput form-control" type="text"
                                                        name="expiration_date" id="skadenca" placeholder="dd-mm-yyyy">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-lg-4 col-form-label">
                                                    <label>Kategoria</label>
                                                </div>
                                                <div class="col-lg-8">
                                                    <select name="category"
                                                        class="category_select col-sm-12 form-control"
                                                        title="Zgjidhni Kategorine">
                                                        <?php $query_category = "SELECT * FROM product_category";
                                                        $result_category = mysqli_query($connection, $query_category);
                                                        while ($row_category = mysqli_fetch_array($result_category)) {
                                                            $id_category = $row_category['id_category'];
                                                            $category = $row_category['category'];
                                                            echo '<option value="' . $row_category['id_category'] . '">' . $category . '</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-lg-4 col-form-label">
                                                    <label>Furnitori</label>
                                                </div>
                                                <div class="col-lg-8">
                                                    <select name="supplierId"
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
                                            <div class="form-group row">
                                                <div class="col-lg-4 col-form-label">
                                                    <label>Perdoruesi</label>
                                                </div>
                                                <div class="col-lg-8">
                                                    <select name="user" class="supplier_select col-sm-12 form-control"
                                                        title="Zgjidhni Perdoruesin">
                                                        <?php $query_user = "SELECT * FROM user";
                                                        $result_user = mysqli_query($connection, $query_user);
                                                        while ($row_user = mysqli_fetch_array($result_user)) {
                                                            $id_user = $row_user['userId'];
                                                            $name = $row_user['name'];
                                                            $lastname = $row_user['lastname'];
                                                            echo '<option value="' . $id_user . '">' . $name . " " . $lastname . '</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-success" type="submit"
                                                name="save_products">Ruaj</button>
                                            <button class="btn btn-secondary" type="button"
                                                data-dismiss="modal">Mbyll</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!-- Modal update prod -->
                        <form action="" method="POST">
                            <div class="modal fade" id="updateModal" tabindex="-1" role="dialog"
                                aria-labelledby="updateModal" aria-hidden="true">
                                <div class="modal-dialog">
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Modifiko te dhenat</h4>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label>Emri Produktit</label>
                                                <input type="text" class="form-control" name="productName"
                                                    id="productName">
                                            </div>
                                            <div class="form-group">
                                                <label>Kodi Fiskal</label>
                                                <input type="text" class="form-control" name="fiscal_code"
                                                    id="fiscal_code">
                                            </div>
                                            <div class="form-group">
                                                <label>Sasia e produktit</label>
                                                <input type="text" class="form-control" name="productUnit"
                                                    id="productUnit">
                                            </div>
                                            <div class="form-group">
                                                <label>Cmimi i blerjes</label>
                                                <input type="text" class="form-control" name="productPriceBought"
                                                    id="productPriceBought">
                                            </div>
                                            <div class="form-group">
                                                <label>Cmimi i shitjes</label>
                                                <input type="text" class="form-control" name="productPriceSold"
                                                    id="productPriceSold">
                                            </div>
                                            <div class="form-group">
                                                <label>Data e skadences</label>
                                                <input class="dateInput expiration_date form-control" type="text"
                                                    name="expiration_date" id="expiration_date"
                                                    data-position="top left">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <input type="text" name="txt_userid" id="txt_userid" value="" hidden>
                                            <button type="submit" class="btn btn-success btn-sm" name="btn_save_product"
                                                id="btn_save">Ruaj</button>
                                            <button type="button" class="btn btn-secondary btn-sm"
                                                data-dismiss="modal">Mbyll</button>
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
        <?php
        if (!empty($productExist)) {
            echo $productExist;
        }
        if (!empty($productCreated)) {
            echo $productCreated;
        }
        if (!empty($productErrorQuery)) {
            echo $productErrorQuery;
        }
        if (!empty($updateProductSuccess)) {
            echo $updateProductSuccess;
        }
        if (!empty($updateProductError)) {
            echo $updateProductError;
        }
        ?>
        <script>
        $(document).ready(function() {

            $('#example').DataTable({
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'print',
                        title: 'Tabela e produkteve ',
                        className: 'btn btn-primary mb-2',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8]
                        }
                    },
                    {
                        extend: 'excelHtml5',
                        title: 'Tabela e produkteve',
                        className: 'btn btn-success mb-2',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8]
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        title: 'Tabela e produkteve',
                        className: 'btn btn-danger mb-2',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8]
                        }
                    },
                ],
                columnDefs: [{
                    targets: "_all",
                    orderable: true
                }],
                "scrollX": true,
                "pagingType": "numbers",
                "processing": true,
                "serverSide": true,
                'serverMethod': 'post',
                columnDefs: [{
                    targets: [9],
                    orderable: false
                }],
                'ajax': {
                    'url': 'showAJAX/showDataTableproduct.php'
                },
                'columns': [{
                        data: 'productName'
                    },
                    {
                        data: 'fiscal_code'
                    },
                    {
                        data: 'productUnit'
                    },
                    {
                        data: 'productPriceBought'
                    },
                    {
                        data: 'productPriceSold'
                    },
                    {
                        data: 'expiration_date'
                    },
                    {
                        data: 'id_category',
                        name: 'product_category.id_category',
                        orderable: true
                    },
                    {
                        data: 'userId',
                        name: 'users.userId',
                        orderable: true
                    },
                    {
                        data: 'supplierId',
                        name: 'supplier.supplierId',
                        orderable: true
                    },
                    {
                        data: 'action'
                    },
                ]
            });
            $('body').on('click', '.updateUser', function(e) {
                var id = $(this).attr('dataId');
                var productName = $(this).attr('val');
                var productUnit = $(this).attr('atrib');
                var productPriceBought = $(this).attr('values');
                var productPriceSold = $(this).attr('value1');
                var expiration_date = $(this).attr('value5');
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