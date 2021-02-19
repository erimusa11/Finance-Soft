<?php
updateManager();
global $connection;

//query for selecting data from table user
$select_data_user = "SELECT * FROM user WHERE userId='$userId'";
$result_data_user = mysqli_query($connection, $select_data_user);
$row_data = mysqli_fetch_assoc($result_data_user);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include '../cssLinks.php' ?>
    <title>Profili</title>
</head>

<body>
    <!-- tap on top starts-->
    <div class="tap-top"><i data-feather="chevrons-up"></i></div>
    <!-- tap on tap ends-->
    <!-- page-wrapper Start-->
    <!-- Page Header Start-->
    <?php include '../topMenu.php' ?>
    <!-- Page Header Ends-->
    <!-- Page Body Start-->
    <div class="page-body-wrapper">
        <!-- Page Sidebar Start-->
        <!-- Page Sidebar Ends-->
        <div class="page-body">
            <!-- Container-fluid starts-->
            <div class="container-fluid">
                <div class="edit-profile ">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Profili im</h4>
                                </div>
                                <div class="card-body">
                                    <form>
                                        <div class="row mb-2">
                                            <div class="col-auto"><img class="img-70 rounded-circle" alt="" src="../../assets/images/user/user.png"></div>
                                            <div class="col">
                                                <h3 class="mb-1">
                                                    <?php echo $row_data['name'] . " " . $row_data['lastname'] ?></h3>
                                            </div>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="form-label">E-mail</label>
                                            <h5><?php echo $row_data['email'] ?></h5>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="form-label">Nr telefoni</label>
                                            <h5><?php echo $row_data['phone'] ?> </h5>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="form-label">Data e regjistrimit</label>
                                            <h5><?php echo $row_data['created_date'] ?></h5>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="form-label">Përdoruesi</label>
                                            <h5><?php echo $row_data['username'] ?></h5>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="form-label">Kodi</label>
                                            <h5><?php echo $row_data['password'] ?></h5>
                                        </div>
                                        <?php
                                        if ($_SESSION['role'] == 1) {
                                            echo '<div class="form-group mb-3">
                                            <label class="form-label">Data e skadencë së lincensës</label>
                                            <h5>' . $row_data['expiration_date'] . '</h5>
                                            </div>';
                                        }
                                        ?>

                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <form class="card" method="POST">
                                <div class="card-header">
                                    <h4 class="card-title mb-0">Modifiko të dhënat</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-6 col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label">Emri</label>
                                                <input type="text" value="<?php echo $userId ?>" name="id_manager" hidden>
                                                <input class="form-control" type="text" name="upd_name" placeholder="Emri">
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label">Mbiemri</label>
                                                <input class="form-control" type="text" name="upd_lastname" placeholder="Mbiemri">
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label">E-mail</label>
                                                <input class="form-control" type="email" name="upd_email" placeholder="E-mail">
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label">Nr telefoni</label>
                                                <input class="form-control" type="number" name="upd_phone" placeholder="Nr telefoni">
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label">Përdoruesi</label>
                                                <input class="form-control" type="text" name="upd_username" placeholder="Përdoruesi">
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label">Fjalëkalimi</label>
                                                <input class="form-control" type="password" name="upd_password" placeholder="********">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-right">
                                    <button class="btn btn-primary" name="upd_manager" type="submit">Modifiko</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Container-fluid Ends-->
        </div>
        <!-- footer start-->
        <?php include '../footer.php' ?>
    </div>
    <?php include '../jsLinks.php' ?>
    <?php
    if (!empty($updateManagerResponse)) {
        echo $updateManagerResponse;
    }
    ?>
</body>

</html>