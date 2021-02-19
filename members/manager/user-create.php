<?php
include 'session.php';
createUser();
modifyUser();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include '../cssLinks.php';?>
    <title>Përdoruesit</title>
</head>

<body>
    <!-- tap on top starts-->
    <div class="tap-top"><i data-feather="chevrons-up"></i></div>
    <!-- tap on tap ends-->
    <!-- page-wrapper Start-->
    <!-- Page Header Start-->
    <?php include '../topMenu.php';?>
    <!-- Page Header Ends-->
    <!-- Page Body Start-->
    <div class="page-body-wrapper">
        <!-- Page Sidebar Start-->
        <!-- Page Sidebar Ends-->
        <div class="page-body">
            <!-- Container-fluid starts-->
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 mt-3">
                        <div class="card-header">
                            <h5 class="text-center">Tabela e përdoruesve </h5>
                        </div>
                        <form class="card" action="" method="POST">
                            <div class="card-body">
                                <div class="d-flex justify-content-end">
                                    <button class="btn btn-info createUser mb-2" type="button" data-toggle="modal"
                                        data-target="#createModal"><i class="fa fa-user"></i>Krijo përdorues</button>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <div class="table-responsive">
                                                <table class="cell-border dataTable hover" id="table-user">
                                                    <thead class="table-primary">
                                                        <tr>
                                                            <th>Emri</th>
                                                            <th>Mbiemri</th>
                                                            <th>Kontakti</th>
                                                            <th>E-mail</th>
                                                            <th style="max-width: 70px">Modifiko</th>
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
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="modifyModal" tabindex="-1" role="dialog" aria-labelledby="modifyModalLabel"
                aria-hidden="true">
                <form action="" method="POST">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="card-title mb-0">Modifiko perdorues</h4>
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">×</span></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <input class="form-control" type="text" id="userIdModal" name="userIdModal" hidden>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="nameModify" class="form-label">Emri</label>
                                            <input class="form-control" type="text" id="nameModify" name="nameModify">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="lastnameModify" class="form-label">Mbiemri*</label>
                                            <input class="form-control" type="text" id="lastnameModify"
                                                name="lastnameModify">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="emailModify" class="form-label">Email</label>
                                            <input class="form-control" type="email" id="emailModify"
                                                name="emailModify">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="phoneModify" class="form-label">Telefon</label>
                                            <input class="form-control" type="text" id="phoneModify" name="phoneModify">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="usernameModify" class="form-label">Perdoruesi
                                                (username)</label>
                                            <input class="form-control" type="text" id="usernameModify"
                                                name="usernameModify">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="passwordModify" class="form-label">Kodi</label>
                                            <input class="form-control" type="passwordModify" id="passwordModify"
                                                name="passwordModify">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <label for="statusModify" class="form-label">Statusi</label>
                                            <select id="statusModify" name="statusModify"
                                                class="status-select selectpicker col-sm-12" title="Zgjidhni statusin">
                                                <option value="1">Jo aktiv</option>
                                                <option value="2">Aktiv</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-success" name="modify" type="submit">Ruaj</button>
                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Mbyll</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <!-- Container-fluid Ends-->
            <!-- create-user modal-->
            <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel"
                aria-hidden="true">
                <form action="" method="POST">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="card-title mb-0">Krijo perdorues</h4>
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">×</span></button>
                            </div>
                            <div class="modal-body">
                                <input type="text" name="id_manager" value="<?php echo $id_user; ?>" hidden>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="name" class="form-label">Emri*</label>
                                                <input class="form-control" type="text" id="name" name="name" required>
                                                <div class="invalid-tooltip">Fusha e emrit nuk duhet të jetë
                                                    bosh.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="lastname" class="form-label">Mbiemri*</label>
                                                <input class="form-control" type="text" id="lastname" name="lastname"
                                                    required>
                                                <div class="invalid-tooltip">Fusha e mbiemrit nuk duhet të jetë
                                                    bosh.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="email" class="form-label">Email</label>
                                                <input class="form-control" type="email" id="email" name="email">
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="phone" class="form-label">Telefon</label>
                                                <input class="form-control" type="text" id="phone" name="phone">
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="username" class="form-label">Përdoruesi
                                                    (username)</label>
                                                <input class="form-control" type="text" id="username" name="username"
                                                    required>
                                                <div class="invalid-tooltip">Fusha e përdoruesit nuk duhet të jetë
                                                    bosh.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="password" class="form-label">Kodi*</label>
                                                <input class="form-control" type="password" id="password"
                                                    name="password" required>
                                                <div class="invalid-tooltip">Fusha e fjalëkalimit nuk duhet të jetë
                                                    bosh.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <span class="text-muted">* fushat janë të parakërkuara</span>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-success" name="create" type="submit">Krijo</button>
                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Mbyll</button>

                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <!-- Container-fluid Ends-->
        </div>
        <!-- footer start-->
        <?php include '../footer.php';?>
    </div>
    <?php include '../jsLinks.php';?>
    <?php
if (!empty($userExist)) {
    echo $userExist;
}
if (!empty($userCreated)) {
    echo $userCreated;
}
if (!empty($userErrorQuery)) {
    echo $userErrorQuery;
}
if (!empty($updateUserSuccess)) {
    echo $updateUserSuccess;
}
if (!empty($updateUserError)) {
    echo $updateUserError;
}
?>
    <script>
    $(document).ready(function() {
        $(".status-select").selectpicker();
        $('body').on('click', '.modifyUser', function() {
            let userId = $(this).val();
            $.ajax({
                method: 'POST',
                url: 'showAJAX/showUser.php',

                data: {
                    userId: userId,
                },
                success: function(data) {
                    var datas = JSON.parse(data);
                    datas.map(function(d) {
                        let username = d.username;
                        let name = d.name;
                        let lastname = d.lastname;
                        let email = d.email;
                        let phone = d.phone;
                        let status = d.status;
                        $('#userIdModal').val(userId);
                        $('#usernameModify').val(username);
                        $('#nameModify').val(name);
                        $('#lastnameModify').val(lastname);
                        $('#emailModify').val(email);
                        $('#phoneModify').val(phone);
                        $('#Modify').val();
                        $('#statusModify option').each(function() {
                            if ($(this).val() == status) {
                                $(this).attr('selected', 'selected');
                            }
                        })
                        $('#statusModify').selectpicker('refresh');
                    })
                }
            })
        })
        $('.invalid-tooltip').on('click', function() {
            $(this).hide();
        })
    });
    </script>
    <script>
    $(document).ready(function() {
        var table = $('#table-user').DataTable({
            'processing': true,
            'serverSide': true,
            'lengthChange': false,
            aoColumnDefs: [{
                orderable: false,
                aTargets: [4]
            }],
            'serverMethod': 'post',
            'ajax': {
                'url': 'showAJAX/showDataTableUser.php'
            },
            'columns': [{
                    data: 'name'
                },
                {
                    data: 'lastname'
                },
                {
                    data: 'phone'
                },
                {
                    data: 'email'
                },
                {
                    data: 'action'
                },
            ],
            dom: 'Bfrtip',
            buttons: [{
                    extend: 'print',
                    title: 'Tabela e përdoruesve',
                    className: 'btn btn-primary mb-2',
                    exportOptions: {
                        columns: [0, 1, 2, 3]
                    }
                },
                {
                    extend: 'excelHtml5',
                    title: 'Tabela e përdoruesve',
                    className: 'btn btn-success mb-2',
                    exportOptions: {
                        columns: [0, 1, 2, 3]
                    }
                },
                {
                    extend: 'pdfHtml5',
                    title: 'Tabela e përdoruesve',
                    className: 'btn btn-danger mb-2',
                    exportOptions: {
                        columns: [0, 1, 2, 3]
                    }
                },
            ]
        });
    });
    </script>
</body>

</html>