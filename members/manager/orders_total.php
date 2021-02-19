<?php
include 'session.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include '../cssLinks.php';?>
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
    <div class="page-body-wrapper sidebar-icon" value=" horizontal-menu">
        <!-- Page Header Start-->
        <?php include '../topMenu.php'?>
        <!-- Page Header Ends -->
        <!-- Page Body Start-->
        <div class="page-body">
            <!-- Page Body Ends-->
            <!-- Container-fluid starts-->
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 mt-3">
                        <div class="card-header">
                            <h5 class="text-center">Faturat</h5>
                        </div>
                        <form action="orders_total.php" method="POST">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <br>
                                            <div class="table-responsive">
                                                <div class="row">
                                                    <div class="col-md-2 col-sm-3">
                                                        <label for="">Data nga</label>
                                                        <input type="text" id="search_fromdate"
                                                            class="dateInput form-control">
                                                    </div>
                                                    <div class="col-md-2 col-sm-3">
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
                                                <table class="cell-border dataTable hover" id="table-invoice">
                                                    <thead class="table-primary">
                                                        <tr>
                                                            <th scope="col">ID faturë </th>
                                                            <th scope="col">Shuma totale </th>
                                                            <th scope="col">Data/ora</th>
                                                            <th scope="col">Përdoruesi / Shitësi</th>
                                                            <th scope="col">Fatura e plotë</th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="card-footer text-right">
                        </div>
                    </div>
                </div>
                <!-- Container-fluid Ends-->
            </div>
            <!-- footer start-->
        </div>
        <?php include '../footer.php'?>
    </div>
    <!-- latest jquery-->
    <?php include '../jsLinks.php'?>
    <script src="../../assets/pages/datepickerInit.js"></script>
    </div>
</body>
<script>
$(document).ready(function() {
    // DataTable
    var dataTable = $('#table-invoice').DataTable({
        columnDefs: [{

            orderable: true
        }],
        "scrollX": true,
        "pagingType": "numbers",
        'processing': true,
        'serverSide': true,
        "order": [
            [2, "desc"]
        ],
        'serverMethod': 'post',
        'searching': true,
        aoColumnDefs: [{
            orderable: false,
            aTargets: [4]
        }],
        'ajax': {
            'url': 'showAJAX/showDataTableOrders.php',
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
                data: 'userId',
                name: 'users.userId',
                orderable: true
            },
            {
                data: 'action'
            },
        ],
        dom: 'Bfrtip',
        buttons: [{
                extend: 'print',
                title: 'Tabela e përdoruesve',
                className: 'btn btn-primary',
                exportOptions: {
                    columns: [0, 1, 2, 3]
                }
            },
            {
                extend: 'excelHtml5',
                title: 'Tabela e përdoruesve',
                className: 'btn btn-success',
                exportOptions: {
                    columns: [0, 1, 2, 3]
                }
            },
            {
                extend: 'pdfHtml5',
                title: 'Tabela e përdoruesve',
                className: 'btn btn-danger',
                exportOptions: {
                    columns: [0, 1, 2, 3]
                }
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