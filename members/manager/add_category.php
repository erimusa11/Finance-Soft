<?php
include 'session.php';
AddCategory();
modifyCategory();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include '../cssLinks.php' ?>
    <title>Kategorite</title>
</head>

<body>
    <!-- tap on top starts-->
    <div class="tap-top"><i data-feather="chevrons-up"></i></div>
    <!-- tap on tap ends-->
    <!-- Page Header Start-->
    <?php //include '../header.php'
    ?>
    <!-- Page Header Ends-->
    <!-- Page Body Start-->
    <div class="page-body-wrapper sidebar-icon">
        <!-- Page Sidebar Start-->
        <?php include '../topMenu.php' ?>
        <!-- Page Sidebar Ends-->
        <div class="page-body">
            <!-- Container-fluid starts-->
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12  mt-3">
                        <div class="card-header">
                            <h5 class="text-center"> Tabela kategorive</h5>
                        </div>
                        <div class="card col-lg-12">

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <div class="d-flex justify-content-end">
                                                <button class="btn btn-info" type="button" data-toggle="modal"
                                                    data-target="#modalCategory">Krijo
                                                    kategori</button>
                                            </div>
                                            <br>
                                            <div class="table-responsive">
                                                <table class="cell-border dataTable hover" id="table-category">
                                                    <thead class="table-primary">
                                                        <tr>
                                                            <th>Emri i kategorise</th>
                                                            <th style="max-width: 100px;">Veprimi</th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal add suppler -->
                <form action="add_category.php" method="POST">
                    <div class="modal fade" id="updateModalCategory" tabindex="-1" role="dialog"
                        aria-labelledby="updateModalCategory" aria-hidden="true">
                        <div class="modal-dialog">
                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Modifiko te dhenat</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group row">
                                        <div class="col-lg-4 col-form-label">
                                            <label>Emri i Kategorise</label>
                                        </div>
                                        <div class="col-lg-6">
                                            <input class=" form-control " type="text" data-language="en"
                                                name="category_name" id="category_name">
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <input type="text" name="txt_userid" id="txt_userid" value="" hidden readonly>
                                    <button type="submit" class="btn btn-success" name="btn_save_category"
                                        id="btn_save">Ruaj</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Mbyll</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- Modal modify suppler -->
                <form class="card" action="add_category.php" method="POST">
                    <div class="modal fade" id="modalCategory" tabindex="-1" role="dialog"
                        aria-labelledby="modalCategory" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Shto Produkt</h5>
                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span
                                            aria-hidden="true">×</span></button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group row">
                                        <div class="col-lg-4 col-form-label">
                                            <label>Emri i kateogrise</label>
                                        </div>
                                        <div class="col-lg-6">
                                            <input type="text" name="category_name" class="form-control"
                                                placeholder="Emri i kategorise">
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-success" type="submit" name="save_category">Ruaj</button>
                                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Mbyll</button>
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
    <?php include '../jsLinks.php' ?>
    <script src="../../assets/pages/datepickerInit.js"></script>

    <?php
    ?> <?php
        if (!empty($categoryExist)) {
            echo $categoryExist;
        }
        if (!empty($categoryCreated)) {
            echo $categoryCreated;
        }
        if (!empty($categoryErrorQuery)) {
            echo $categoryErrorQuery;
        }
        if (!empty($updateCategorySuccess)) {
            echo $updateCategorySuccess;
        }
        if (!empty($updateCategoryError)) {
            echo $updateCategoryError;
        }

        ?>
    <script>
    $(document).ready(function() {
        $('#table-category').DataTable({
            'lengthChange': false,
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            'ajax': {
                'url': 'showAJAX/showDataTableCategory.php'
            },

            aoColumnDefs: [{
                orderable: false,
                aTargets: [1]
            }],
            'columns': [{
                    data: 'category'
                },
                {
                    data: 'action'
                },
            ],
            dom: 'Bfrtip',
            buttons: [{
                    extend: 'print',
                    title: 'Kategorite e produkteve',
                    className: 'btn btn-primary mb-2',
                    exportOptions: {
                        columns: [0]
                    }
                },
                {
                    extend: 'excelHtml5',
                    title: 'Kategorite e produkteve',
                    className: 'btn btn-success mb-2',
                    exportOptions: {
                        columns: [0]
                    }
                },
                {
                    extend: 'pdfHtml5',
                    title: 'Kategorite e produkteve',
                    className: 'btn btn-danger mb-2',
                    exportOptions: {
                        columns: [0]
                    }
                },
            ]
        });
        $('body').on('click', '.updateCategory', function(e) {
            var id = $(this).attr('dataId');
            var category = $(this).attr('val');
            $('#txt_userid').val(id);
            $('#category_name').val(category);
        });
    });
    </script>
</body>

</html>