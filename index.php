<?php
include 'functions.php';
login();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="">
    <link rel="apple-touch-icon" sizes="180x180" href="assets/images/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/images/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicon/favicon-16x16.png">
    <link rel="manifest" href="assets/images/favicon/site.webmanifest">
    <link rel="mask-icon" href="assets/images/favicon/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
    <title>Hyr - POS System</title>
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="assets/login/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="assets/login/fonts/iconic/css/material-design-iconic-font.min.css">
    <link rel="stylesheet" type="text/css" href="assets/login/util.css">
    <link rel="stylesheet" type="text/css" href="assets/login/main.css">

    <!-- Bootstrap css-->
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
    <!-- App css-->
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <link id="color" rel="stylesheet" href="assets/css/color-1.css" media="screen">
    <!-- Responsive css-->
    <link rel="stylesheet" type="text/css" href="assets/css/responsive.css">
    <style>
    a {
        color: #EEFBFB;
    }

    a:hover {
        color: #707070;
    }
    </style>
</head>

<body>
    <div class="container-login100" style="background-image: url('assets/login/background.jpg');">
        <div class="wrap-login100 p-l-55 p-r-55 p-t-80 p-b-80">
            <form class="login100-form validate-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"
                method="POST">
                <div class="text-center">
                    <img class="mb-4" src="assets/login/icon.png" alt="" width="100" height="100">
                </div>
                <span class="login100-form-title p-b-37">
                    Hyr në Platforme
                </span>

                <div class="wrap-input100 validate-input m-b-20" data-validate="Përdoruesi">
                    <input class="input100" type="text" name="username" placeholder="Përdoruesi">
                    <span class="focus-input100"></span>
                </div>

                <div class="wrap-input100 validate-input m-b-25" data-validate="Fjalëkalimi">
                    <input class="input100" type="password" name="password" placeholder="Fjalëkalimi">
                    <span class="focus-input100"></span>
                </div>
                <div class="container-login100-form-btn m-t-20">
                    <button class="login100-form-btn" name="login" type="submit">
                        Hyr
                    </button>
                </div>
            </form>
            <?php
if (!empty($_SESSION['licenseExpired'])) {
    echo $_SESSION['licenseExpired'];
}
if (!empty($accountNotExistErr)) {
    echo $accountNotExistErr;
}
if (!empty($emailPwdErr)) {
    echo $emailPwdErr;
}
if (!empty($emailActivationErr)) {
    echo $emailActivationErr;
}
?>
        </div>

    </div>


    <!-- latest jquery-->
    <script src="assets/js/jquery-3.5.1.min.js"></script>
    <!-- Bootstrap js-->
    <script src="assets/js/bootstrap/popper.min.js"></script>
    <script src="assets/js/bootstrap/bootstrap.js"></script>
    <!-- feather icon js-->
    <script src="assets/js/icons/feather-icon/feather.min.js"></script>
    <script src="assets/js/icons/feather-icon/feather-icon.js"></script>

    <!-- Theme js-->
    <script src="assets/js/script.js"></script>
    <script src="assets/login/main.js"></script>
    <!-- login js-->
    <!-- Plugin used-->
</body>

</html>