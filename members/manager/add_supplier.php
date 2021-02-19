<?php
include 'session.php';
AddSupplier();
modifySupplier();
deleteSupplier();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include '../cssLinks.php' ?>
    <title>Furnitorët</title>
</head>

<body>
    <!-- tap on top starts-->
    <div class="tap-top"><i data-feather="chevrons-up"></i></div>
    <!-- tap on tap ends-->
    <!-- page-wrapper Start-->
    <div class="page-wrapper" id="pageWrapper">
        <!-- Page Header Start-->
        <?php include '../topMenu.php'; ?>
        <!-- Page Header Ends
                              -->
        <!-- Page Body Start-->

        <!-- Page Sidebar Start-->
        <div class="page-body">
            <!-- Container-fluid starts-->
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 mt-3">
                        <div class="card-header">
                            <h4 class="text-center"> Tabela furnitorëve</h4>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <div class="d-flex justify-content-end">
                                                <button class="btn btn-info" type="button" data-toggle="modal"
                                                    data-target="#modalAddFurnitor">Shto furnitor</button>
                                            </div>
                                            <div class="table-responsive">
                                                <table class="cell-border dataTable hover" id="table-supplier">
                                                    <thead class="table-primary">
                                                        <tr>
                                                            <th>Emri</th>
                                                            <th>E-mail</th>
                                                            <th>Kontakti</th>
                                                            <th>Veprimet</th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal add suppler -->
                        <form action="" method="POST">
                            <div class="modal fade" id="modalAddFurnitor" tabindex="-1" role="dialog"
                                aria-labelledby="modalAddFurnitor" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Shto Furnitor</h5>
                                            <button class="close" type="button" data-dismiss="modal"
                                                aria-label="Close"><span aria-hidden="true">×</span></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group row">
                                                <div class="col-lg-4 col-form-label">
                                                    <label>Emri</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <input type="text" name="supp_name" class="form-control"
                                                        placeholder="Emri">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-lg-4 col-form-label">
                                                    <label>E-mail</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <input type="email" name="supp_mail" class="form-control"
                                                        placeholder="shembull@gmail.com">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-lg-4 col-form-label">
                                                    <label>Kontakti</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <input type="number" name="supp_phone" class="form-control"
                                                        placeholder="06X XX XX XXX">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-success" type="submit"
                                                name="save_supplier">Ruaj</button>
                                            <button class="btn btn-secondary" type="button"
                                                data-dismiss="modal">Mbyll</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <!-- Modal modify suppler -->
                        <form action="" method="POST">
                            <div class="modal fade" id="updateModal" tabindex="-1" role="dialog"
                                aria-labelledby="updateModal" aria-hidden="true">
                                <div class="modal-dialog">
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Modifiko të dhënat</h4>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label>Emri</label>
                                                <input type="text" class="form-control" name="name" id="name">
                                            </div>
                                            <div class="form-group">
                                                <label>E-mail</label>
                                                <input type="email" class="form-control" name="email" id="email">
                                            </div>
                                            <div class="form-group">
                                                <label>Kontakti</label>
                                                <input type="text" class="form-control" name="phone" id="phone">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <input type="text" name="txt_userid" id="txt_userid" value="" hidden>
                                            <button type="submit" class="btn btn-success btn-sm"
                                                name="btn_save_supplier" id="btn_save">Ruaj</button>
                                            <button type="button" class="btn btn-secondary btn-sm"
                                                data-dismiss="modal">Mbyll</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <!-- Modal delete suppler-->
                        <form class="card" action="" method="POST">
                            <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog"
                                aria-labelledby="deleteModal" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Fshini furnitor</h5>
                                            <button class="close" type="button" data-dismiss="modal"
                                                aria-label="Close"><span aria-hidden="true">×</span></button>
                                        </div>
                                        <div class="modal-body">
                                            <h5 class="modal-title">Jeni të sigurtë që dëshironi të kryeni këtë veprim?
                                            </h5>
                                        </div>
                                        <div class="modal-footer">
                                            <input type="text" name="del_id" id="del_id" value="" hidden>
                                            <button class="btn btn-success" type="submit"
                                                name="delete_supplier">Fshi</button>
                                            <button class="btn btn-secondary" type="button"
                                                data-dismiss="modal">Mbyll</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- Container-fluid Ends-->
            </div>
            <!-- footer start-->
            <?php include '../footer.php' ?>
        </div>
    </div>

    <?php include '../jsLinks.php' ?>
    <?php
    if (!empty($supplierExist)) {
        echo $supplierExist;
    }
    if (!empty($supplierCreated)) {
        echo $supplierCreated;
    }
    if (!empty($supplierErrorQuery)) {
        echo $supplierErrorQuery;
    }
    if (!empty($updateSupplierSuccess)) {
        echo $updateSupplierSuccess;
    }
    if (!empty($updateSupplierError)) {
        echo $updateSupplierError;
    }
    if (!empty($deleteSupplierSuccess)) {
        echo $deleteSupplierSuccess;
    }
    if (!empty($deleteSupplierError)) {
        echo $deleteSupplierError;
    }

    ?>

    <script>
    $(document).ready(function() {
        $('#table-supplier').DataTable({
            'processing': true,
            'serverSide': true,

            'serverMethod': 'post',
            aoColumnDefs: [{
                orderable: false,
                aTargets: [3]
            }],
            'ajax': {
                'url': 'showAJAX/showDataTableSupplier.php'
            },
            'columns': [{
                    data: 'supplierName'
                },
                {
                    data: 'supplierEmail'
                },
                {
                    data: 'supplierPhone'
                },
                {
                    data: 'action'
                },
            ],
            dom: 'Bfrtip',
            buttons: [{
                    extend: 'print',
                    title: 'Tabela e furnitoreve',
                    className: 'btn btn-primary',
                    exportOptions: {
                        columns: [0, 1, 2]
                    }
                },
                {
                    extend: 'excelHtml5',
                    title: 'Tabela e furnitoreve',
                    className: 'btn btn-success',
                    exportOptions: {
                        columns: [0, 1, 2]
                    }
                },
                {
                    extend: 'pdfHtml5',
                    title: 'Tabela e furnitoreve',
                    className: 'btn btn-danger',
                    exportOptions: {
                        columns: [0, 1, 2]
                    }
                },
            ]
        });

        $('body').on('click', '.updateUser', function(e) {
            var id = $(this).attr('dataId');
            var name = $(this).attr('val');
            var email = $(this).attr('atrib');
            var phone = $(this).attr('values');
            $('#txt_userid').val(id);
            $('#name').val(name);
            $('#phone').val(phone);
            $('#email').val(email);
        });

        $('body').on('click', '.deleteUser', function(e) {
            var dataid = $(this).attr('dataid');
            $('#del_id').val(dataid);
        });

    });
    </script>
</body>

</html>