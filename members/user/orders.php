<?php
include 'session.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php  include '../cssLinks.php'; ?>
    <title>Faturat</title>
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
    <div class="page-wrapper" id="pageWrapper">
        <!-- Page Header Start-->
        <?php include '../topMenu.php'; ?>
        <!-- Page Header Ends                              -->
        <!-- Page Body Start-->
        <div class="page-body-wrapper sidebar-icon" value=" horizontal-menu">
            <!-- Page Sidebar Start-->

            <!-- Page Sidebar Ends-->
            <div class="page-body">
                <!-- Container-fluid starts-->
                <div class="container-fluid">
                    <div class="row">

                        <div class="col-lg-12 mt-3">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="text-center">Faturat</h5>
                                </div>
                                <form action="" method="POST">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group mb-3">
                                                    <br>
                                                    <div class="table-responsive">
                                                        <div class="row">
                                                            <div class="col-md-2 col-sm-2">
                                                                <label for="">Data nga</label>
                                                                <input type="text" id="search_fromdate"
                                                                    class="form-control dateInput">
                                                            </div>
                                                            <div class="col-md-2 col-sm-2">
                                                                <label for="">Deri ne</label>
                                                                <input type="text" id="search_todate"
                                                                    class="form-control dateInput">
                                                            </div>
                                                            <div class="col-3">
                                                                <br>
                                                                <button type="button" id="btn_search"
                                                                    class="btn btn-info mt-2">Kërko</button>
                                                            </div>
                                                        </div>

                                                        <br>

                                                        <table class="cell-border dataTable hover" id="table-order">
                                                            <thead class="table-primary">
                                                                <tr>
                                                                    <th scope="col">ID fatura </th>
                                                                    <th scope="col">Shuma totale </th>
                                                                    <th scope="col">Data/ora</th>
                                                                    <th scope="col">Shiko produktet e faturës</th>
                                                                </tr>
                                                            </thead>
                                                        </table>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- Container-fluid Ends-->
                </div>
                <!-- footer start-->

            </div>
            <?php include '../footer.php'; ?>
        </div>

        <!-- latest jquery-->
        <?php include '../jsLinks.php'; ?>

    </div>
</body>
<script src="../../assets/pages/datepickerInit.js"></script>
<script>
$(document).ready(function() {

    // DataTable
    var dataTable = $('#table-order').DataTable({
        'processing': true,
        "lengthChange": false,
        'serverSide': true,
        'serverMethod': 'post',
        'searching': true,
        "order": [[ 2, "desc" ]],
        'ajax': {
            'url': 'showAjaxUser/showDataTableOrdersUser.php',
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
                data: 'orderDateTimeStamp'
            },
            {
                data: 'totalAmount'
            },
            {
                data: 'orderDate'
            },

            {
                data: 'action'
            },
        ],
        dom: 'Bfrtip',
        buttons: [{
                extend: 'print',
                title: 'Fatura',
                className: 'btn btn-primary mb-2',
            },
            {
                extend: 'excelHtml5',
                title: 'Fatura',
                className: 'btn btn-success mb-2',
            },
            {
                extend: 'pdfHtml5',
                title: 'Fatura',
                className: 'btn btn-danger mb-2',
            },
        ]
    });

    // Search button
    $('#btn_search').click(function() {
        dataTable.draw();
    });

});
</script>

</html>