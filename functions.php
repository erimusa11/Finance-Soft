<?php

ob_start();
session_start();

include 'dbconnection.php';

function login()
{
    global $connection;
    global $accountNotExistErr, $emailPwdErr, $emailActivationErr;
    $_SESSION['licenseExpired'] = $_SESSION['expirationDate'] = $accountNotExistErr = $emailPwdErr = $emailActivationErr = '';
    if (isset($_POST['login'])) {
        $usernameInput = $_POST['username'];
        $passwordInput = $_POST['password'];

        // clean data
        $usernameInput = mysqli_real_escape_string($connection, $usernameInput);
        $passwordInput = mysqli_real_escape_string($connection, $passwordInput);

        $query = "SELECT * FROM user WHERE username = '$usernameInput'";
        $result = mysqli_query($connection, $query);
        $rowCount = mysqli_num_rows($result);

        if (!$result) {
            die('SQL query failed: ' . mysqli_error($connection));
        }

        $now = date('Y-m-d H:i:s');

        //check if manager account is active
        $queryManagerCheck = "SELECT DATEDIFF(expiration_date, '$now') AS Datedifference, expiration_date
        FROM user
        WHERE user_role = 1";

        $resultManagerCheck = mysqli_query($connection, $queryManagerCheck);
        $rowManagerCheck = mysqli_fetch_assoc($resultManagerCheck);
        $dateDiff = $rowManagerCheck['Datedifference'];
        $managerExpirationDate = date('d-m-Y H:i:s', strtotime($rowManagerCheck['expiration_date']));

        if ($dateDiff <= 0) {
            $_SESSION['licenseExpired'] = '<div class="alert alert-danger dark alert-dismissible fade show mt-3" role="alert">Lincesa e juaj ka mbaruar, kontaktoni<strong> <a href="mailto:commercialsoftwareal@gmail.com">commercialsoftwareal@gmail.com</a></strong>!
            <button class="close" type="button" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
        </div';
        } else {
            if ($dateDiff < 14) {
                $_SESSION['expirationDate'] = '
                <div class="alert alert-warning dark alert-dismissible fade show mt-3" role="alert"><i class="mr-2 text-dark" data-feather="clock"></i><strong class="text-dark">Lincesa e juaj do të mbarojë më ' . $managerExpirationDate . '! Kontaktoni <a href="mailto:commercialsoftwareal@gmail.com">commercialsoftwareal@gmail.com</a></strong>
                    <button class="close" type="button" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div';
            }
            if ($rowCount <= 0) {
                $accountNotExistErr = '<div class="alert alert-danger dark alert-dismissible fade show mt-3" role="alert"><strong>Ky perdorues nuk ekziston!</strong>
                                          <button class="close" type="button" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                      </div>';
            } else {
                while ($row = mysqli_fetch_array($result)) {
                    $username = $row['username'];
                    $password = $row['password'];
                    $name = $row['name'];
                    $lastname = $row['lastname'];
                    $email = $row['email'];
                    $phone = $row['phone'];
                    $role = $row['user_role'];
                    $status = $row['status'];
                    $id_user = $row['userId'];

                    //$passwordVerify = password_verify($passwordInput, $password);

                    if ($status == 2) {
                        if ($usernameInput == $username && $password == $passwordInput) {
                            $_SESSION['username'] = $username;
                            $_SESSION['name'] = $name;
                            $_SESSION['lastname'] = $lastname;
                            $_SESSION['email'] = $email;
                            $_SESSION['phone'] = $phone;
                            $_SESSION['role'] = $role;
                            $_SESSION['user_id'] = $id_user;

                            if ($_SESSION['role'] == 1) {
                                return header('Location: ./members/manager/index.php');
                            }
                            if ($_SESSION['role'] == 2) {
                                return header('Location: ./members/user/index.php');
                            }
                        } else {
                            $emailPwdErr = '<div class="alert alert-danger dark alert-dismissible fade show mt-3" role="alert"><strong>Perdoruesi ose kodi eshte gabim, provoni perseri!</strong>
                                            <button class="close" type="button" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                        </div>';
                        }
                    } else {
                        $emailActivationErr = '<div class="alert alert-danger dark alert-dismissible fade show mt-3" role="alert"><strong>Llogaria juaj eshte jo aktive! Kontaktoni me menaxherin! </strong>
                    <button class="close" type="button" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                  </div>';
                    }
                }
            }
        }
    }
}

function logout()
{
    if (isset($_POST['logout'])) {
        $_SESSION = [];
        session_destroy();

        return header('Location: ../../index.php');
        exit();
    }
}
//create hash password
function hashPassword($password)
{
    $pass_hash = password_hash($password, PASSWORD_BCRYPT);

    return $pass_hash;
}
//create user
function createUser()
{
    global $connection;
    global $userExist, $userCreated, $userErrorQuery;
    $userExist = $userCreated = $userErrorQuery = '';
    if (isset($_POST['create'])) {
        $name = mysqli_real_escape_string($connection, $_POST['name']);
        $lastname = mysqli_real_escape_string($connection, $_POST['lastname']);
        $email = mysqli_real_escape_string($connection, $_POST['email']);
        $phone = mysqli_real_escape_string($connection, $_POST['phone']);
        $username = mysqli_real_escape_string($connection, $_POST['username']);
        $password = mysqli_real_escape_string($connection, $_POST['password']);
        //$password_hash = hashPassword($password);

        $now = date('Y-m-d H:i:s');
        $role = 2;
        $status = 2;

        $username_check_query = "SELECT * FROM user WHERE username = '{$username}'";
        $result_check_query = mysqli_query($connection, $username_check_query);
        $count_users = mysqli_num_rows($result_check_query);

        if ($count_users > 0) {
            $userExist = '<script language="javascript">
                            swal("Gabim!", "Ky perdorues ekziston!", "error")
                          </script>';
        } else {
            $query_insert = "INSERT INTO user (username, password, name, lastname, email, phone, user_role, created_date, status)
            VALUES ('$username', '$password', '$name', '$lastname', '$email', '$phone', '$role', '$now', '$status')";
            $result_insert = mysqli_query($connection, $query_insert);
            if ($result_insert) {
                $userCreated = '<script language="javascript">
                            swal("Sukses!", "Përdoruesi i ri u krijua!", "success")
                          </script>';
            } else {
                $userErrorQuery = '<script language="javascript">
                           swal("Gabim!", "Një gabim i papritur ka ndodhur! Provoni përsëri!", "error")
                          </script>';
            }
        }
    }
}
//modify user
function modifyUser()
{
    global $connection;
    global $updateUserSuccess, $updateUserError;
    $updateUserSuccess = $updateUserError = '';
    if (isset($_POST['modify'])) {
        $userId = $_POST['userIdModal'];

        $updateColumn = '';

        $name = addslashes($_POST['nameModify']);
        if (!empty($name)) {
            $updateColumn .= "name = '$name',";
        }

        $lastname = addslashes($_POST['lastnameModify']);
        if (!empty($lastname)) {
            $updateColumn .= "lastname = '$lastname',";
        }
        $email = addslashes($_POST['emailModify']);
        if (!empty($email)) {
            $updateColumn .= "email = '$email',";
        }
        $phone = addslashes($_POST['phoneModify']);
        if (!empty($phone)) {
            $updateColumn .= "phone = '$phone',";
        }
        $username = addslashes($_POST['usernameModify']);
        if (!empty($username)) {
            $updateColumn .= "username = '$username',";
        }

        $password = addslashes($_POST['passwordModify']);
        //$password_hash = hashPassword($password);
        if (!empty($password)) {
            $updateColumn .= "password = '$password',";
        }

        $status = addslashes($_POST['statusModify']);
        if (!empty($status)) {
            $updateColumn .= "status = '$status',";
        }

        $updateColumn = rtrim($updateColumn, ',');

        $query = "UPDATE user SET $updateColumn WHERE userId = '$userId'";
        $result = mysqli_query($connection, $query);

        if ($result) {
            $updateUserSuccess = '<script language="javascript">
                                  swal("Sukses!", "Përdoruesi u modifikua!", "success")
                                  </script>';
        } else {
            $updateUserError = '<script language="javascript">
                                swal("Gabim!", "Nje gabim i papritur ka ndodhur! Provoni përsëri!", "error")
                                </script>';
        }
    }
}
//modify user

//seleziona utente
function userSelect()
{
    global $connection;
    $user_query = "SELECT userId, CONCAT(name, ' ', lastname) AS fullName
    FROM user
    WHERE user_role = 2
    ORDER BY username ASC";
    $user_result = mysqli_query($connection, $user_query);
    while ($user_row = mysqli_fetch_array($user_result)) {
        $userId = $user_row['userId'];
        $fullName = $user_row['fullName'];
        echo '<option value="' . $userId . '">' . $fullName . '</option>';
    }
}

//seleziona utente

// Create suplier
function AddSupplier()
{
    global $connection;
    global $supplierCreated, $supplierExist, $supplierErrorQuery;
    $supplierCreated = $supplierExist = $supplierErrorQuery = '';

    if (isset($_POST['save_supplier'])) {
        $name = addslashes($_POST['supp_name']);
        $email = addslashes($_POST['supp_mail']);
        $phone = addslashes($_POST['supp_phone']);

        $supplier_check_query = "SELECT * FROM supplier WHERE supplierEmail = '$email'";
        $result_check_query = mysqli_query($connection, $supplier_check_query);
        $count_supplier = mysqli_num_rows($result_check_query);

        if ($count_supplier > 0) {
            $supplierExist = '<script language="javascript">
                                swal("Gabim!", "Ky furnitor ekziston!", "error")
                             </script>';
        } else {
            $query_insert = "INSERT INTO supplier ( supplierName,supplierEmail, supplierPhone)
            VALUES ('$name','$email', '$phone')";
            $result_insert = mysqli_query($connection, $query_insert);
            if ($result_insert) {
                $supplierCreated = '<script language="javascript">
                                    swal("Sukses!", "Furnitori u krijua me sukses!", "success")
                                  </script>';
            } else {
                $supplierErrorQuery = '<script language="javascript">
                                        swal("Gabim!", "Një gabim ka ndodhur gjatë ngarkimit të furnitorit! Provoni përsëri!", "error")
                                       </script>';
            }
        }
    }
}
// Create suplier

//modify supplier
function modifySupplier()
{
    global $connection;
    global $updateSupplierSuccess, $updateSupplierError;
    $updateSupplierSuccess = $updateSupplierError = '';
    if (isset($_POST['btn_save_supplier'])) {
        $supplier_id = $_POST['txt_userid'];

        $updateColumnSupplier = '';

        $name = addslashes($_POST['name']);
        if (!empty($name)) {
            $updateColumnSupplier .= "supplierName = '$name',";
        }

        $email = addslashes($_POST['email']);
        if (!empty($email)) {
            $updateColumnSupplier .= "supplierEmail = '$email',";
        }
        $phone = addslashes($_POST['phone']);
        if (!empty($phone)) {
            $updateColumnSupplier .= "supplierPhone = '$phone',";
        }

        $updateColumnSupplier = rtrim($updateColumnSupplier, ',');

        $query_update = "UPDATE supplier SET $updateColumnSupplier WHERE supplierId = '$supplier_id'";
        $result_update = mysqli_query($connection, $query_update);

        if ($result_update) {
            $updateSupplierSuccess = '<script language="javascript">
            swal("Sukses!", "Furnitori u modifikua me sukses!", "success")
          </script>';
        } else {
            $updateSupplierError = '<script language="javascript">
            swal("Gabim!", "Një gabim ka ndodhur gjatë modifikimit të furnitorit! Provoni përsëri!", "error")
           </script>';
        }
    }
}
//modify supplier

// delete supplier function
function deleteSupplier()
{
    global $connection;
    global $deleteSupplierSuccess, $deleteSupplierError;
    $deleteSupplierSuccess = $deleteSupplierError = '';

    if (isset($_POST['delete_supplier'])) {
        $supplierid = $_POST['del_id'];

        $delete_query = "DELETE FROM supplier WHERE supplierId='$supplierid'";

        $delete_result = mysqli_query($connection, $delete_query);

        if ($delete_result) {
            $deleteSupplierSuccess = '<script language="javascript">
            swal("Sukses!", "Furnitori u fshi me sukses!", "success")
          </script>';
        } else {
            $deleteSupplierError = '<script language="javascript">
            swal("Gabim!", "Një gabim ka ndodhur gjatë fshirjes të furnitorit! Provoni përsëri!", "error")
           </script>';
        }
    }
}
// delete supplier function

//create products
function AddProduct()
{
    global $connection;
    global $productCreated, $productExist, $productErrorQuery;
    $productCreated = $productExist = $productErrorQuery = '';

    if (isset($_POST['save_products'])) {
        $productName = addslashes($_POST['productName']);
        $fiscal_code = addslashes($_POST['fiscal_code']);
        $productUnit = addslashes($_POST['productUnit']);
        $productPriceBought = addslashes($_POST['productPriceBought']);
        $productPriceSold = addslashes($_POST['productPriceSold']);

        $user = addslashes($_POST['user']);
        $category = addslashes($_POST['category']);
        $supplierId = addslashes($_POST['supplierId']);
        $expiration_date = date('Y-m-d', strtotime($_POST['expiration_date']));
        $product_check_query = "SELECT * FROM product WHERE productName = '$productName'";
        $result_check_query = mysqli_query($connection, $product_check_query);
        $count_product = mysqli_num_rows($result_check_query);

        if ($count_product > 0) {
            $productExist = '<script language="javascript">
                               swal("Gabim!", "Ky produkt ekziston!", "error")
                            </script>';
        } else {
            $query_insert = "INSERT INTO product(productName,fiscal_code,productUnit, productPriceBought,productPriceSold,expiration_date,id_category,userId,supplierId) VALUES('$productName','$fiscal_code','$productUnit','$productPriceBought','$productPriceSold','$expiration_date','$category',' $user','$supplierId')";
            $result_insert = mysqli_query($connection, $query_insert);

            if ($result_insert) {
                $productCreated = '<script language="javascript">
                swal("Sukses!", "Produkti u krijua me sukses!", "success")
                                   </script>';
            } else {
                $productErrorQuery = '<script language="javascript">
                                       swal("Gabim!", "Ka ndodhur një gabim gjatë krijimit të produktit! Provoni përsëri!", "error")
                                   </script>';
            }
        }
    }
}
//create products

// modify product
function modifyProduct()
{
    global $connection;
    global $updateProductError, $updateProductSuccess;
    $updateProductError = $updateProductSuccess = '';

    if (isset($_POST['btn_save_product'])) {
        $product_id = addslashes($_POST['txt_userid']);

        $updateColumnProduct = '';

        $productName = addslashes($_POST['productName']);
        if (!empty($productName)) {
            $updateColumnProduct .= "productName = '$productName',";
        }

        $productUnit = addslashes($_POST['productUnit']);
        if (!empty($productUnit)) {
            $updateColumnProduct .= "productUnit = '$productUnit',";
        }
        $productPriceBought = addslashes($_POST['productPriceBought']);
        if (!empty($productPriceBought)) {
            $updateColumnProduct .= "productPriceBought = '$productPriceBought',";
        }
        $productPriceSold = addslashes($_POST['productPriceSold']);
        if (!empty($productPriceSold)) {
            $updateColumnProduct .= "productPriceSold = '$productPriceSold',";
        }
        $expiration_date = date('Y-m-d', strtotime($_POST['expiration_date']));
        if (!empty($expiration_date)) {
            $updateColumnProduct .= "expiration_date = '$expiration_date',";
        }
        $fiscal_code = $_POST['fiscal_code'];
        if (!empty($fiscal_code)) {
            $updateColumnProduct .= "fiscal_code = '$fiscal_code',";
        }

        $updateColumnProduct = rtrim($updateColumnProduct, ',');

        $query_update = "UPDATE product SET $updateColumnProduct WHERE productId = '$product_id'";
        $result_update = mysqli_query($connection, $query_update);

        if ($result_update) {
            $updateProductSuccess = '<script language="javascript">
            swal("Sukses!", "Te dhenat u modifikuan me sukses!", "success")
        </script>';
        } else {
            $updateProductError = '<script language="javascript">
            swal("Gabim!", "Ka ndodhur një gabim gjatë modifikimit të produktit! Provoni përsëri!", "error")
        </script>';
        }
    }
}
// modify product

// delete product
// function deleteProduct()
// {
//     global $connection;
//     global $deleteProductSuccess, $deleteProductError;
//     $deleteProductSuccess = $deleteProductError = '';
//     if (isset($_POST['delete_product'])) {
//         $productid = $_POST['del_id'];

//         $delete_query = "DELETE FROM product WHERE productId='$productid'";

//         $delete_result = mysqli_query($connection, $delete_query);

//         if ($delete_result) {
//             $deleteProductSuccess = '<script language="javascript">
//             swal("Sukses!", "Produkti u krijua me sukses!", "success")
//                                </script>';
//         } else {
//             $deleteProductError = true;
//         }
//     }
// }
// delete product

//create category function
function AddCategory()
{
    global $connection;
    global $categoryCreated, $categoryExist, $categoryErrorQuery;
    $categoryCreated = $categoryExist = $categoryErrorQuery = '';

    if (isset($_POST['save_category'])) {
        $category_name = addslashes($_POST['category_name']);

        $product_check_query = "SELECT * FROM product_category WHERE category = '$category_name'";
        $result_check_query = mysqli_query($connection, $product_check_query);
        $count_product = mysqli_num_rows($result_check_query);

        if ($count_product > 0) {
            $categoryExist = '<script language="javascript">
            swal("Gabim!", "Kjo kategori ekziston!", "error")
        </script>';
        } else {
            $query_insert = "INSERT INTO product_category(category) VALUES('$category_name')";
            $result_insert = mysqli_query($connection, $query_insert);

            if ($result_insert) {
                $categoryCreated = '<script language="javascript">
                swal("Sukses!", "Kategoria u krijua me sukses!", "success")
            </script>';
            } else {
                $categoryErrorQuery = '<script language="javascript">
                swal("Gabim!", "Ka ndodhur një gabim gjatë krijimit të kategorisë! Provoni përsëri!", "error")
            </script>';
            }
        }
    }
}
//create category function

//modify category function
function modifyCategory()
{
    global $connection;
    global $updateCategorySuccess, $updateCategoryError;
    $updateCategorySuccess = $updateCategoryError = '';

    if (isset($_POST['btn_save_category'])) {
        $category_id = $_POST['txt_userid'];

        $updateColumncategory = '';

        $category_name = htmlentities($_POST['category_name']);
        if (!empty($category_name)) {
            $updateColumncategory .= "category = '$category_name',";
        }

        $updateColumncategory = rtrim($updateColumncategory, ',');

        $query_update = "UPDATE product_category SET $updateColumncategory WHERE id_category = '$category_id'";
        $result_update = mysqli_query($connection, $query_update);

        if ($result_update) {
            $updateCategorySuccess = '<script language="javascript">
            swal("Sukses!", "Kategoria u modifikua me sukses!", "success")
        </script>';
        } else {
            $updateCategoryError = '<script language="javascript">
            swal("Gabim!", "Ka ndodhur një gabim gjatë modifikimit të kategorisë! Provoni përsëri!", "error")
        </script>';
        }
    }
}
//modify category function

//register invoice
function registerInvoice()
{
    global $responseInvoice;
    $responseInvoice = '';
    if (isset($_POST['save'])) {
        global $connection;
        $now = date('Y-m-d h:i:s');
        $timestamp = time();
        $userId = $_POST['userId'];
        $invoiceProductId = $_POST['invoiceProductId'];
        $totalProductUnit = $_POST['totalProductUnit'];
        $productPrice = $_POST['productPrice'];
        $productUnitBuy = $_POST['productUnitBuy'];
        $totalPrice = $_POST['totalPrice'];
        $totalPriceInvoice = $_POST['totalPriceInvoice'];

        if ($invoiceProductId == 0) {
        } else {
            for ($i = 0; $i < count($invoiceProductId); ++$i) {
                $newTotalProductUnit = $totalProductUnit[$i] - $productUnitBuy[$i];
                $queryUpdateUnit = "UPDATE product
            SET productUnit = '$newTotalProductUnit'
            WHERE productId = '$invoiceProductId[$i]'";
                $resultUpdateUnit = mysqli_query($connection, $queryUpdateUnit);
            }

            $queryOrder = "INSERT INTO orders (totalAmount, orderDate, orderDateTimeStamp, userId)
            VALUES('$totalPriceInvoice', '$now', '$timestamp', '$userId')";
            $resultOrder = mysqli_query($connection, $queryOrder);
            $orderId = mysqli_insert_id($connection);
            if ($resultOrder) {
                for ($i = 0; $i < count($invoiceProductId); ++$i) {
                    $queryOrderItems = "INSERT INTO order_items (product_id, product_unit, product_price, user_Id, order_id)
            VALUES('$invoiceProductId[$i]', '$productUnitBuy[$i]', '$totalPrice[$i]', '$userId', '$orderId')";
                    $resultOrderItems = mysqli_query($connection, $queryOrderItems);
                    if ($resultOrderItems) {
                        $responseInvoice = '<script language="javascript">
                      swal({
                        title: "Rregjistrimi u krye me sukses. ",
                        text: "Dëshironi të printoni faturë?",
                        icon: "success",
                        buttons: true,
                        dangerMode: true,
                            buttons: {
                            cancel: "Jo",
                            true: "Po"
                        },
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                           window.location.href = "orders_item_total.php?nr=' . $orderId . '";
                        } else {
                            swal.close();
                        }
                    })</script>';
                    } else {
                        $responseInvoice = '<script language="javascript">
                        swal("Gabim!", "Ka ndodhur një gabim gjatë rregjistrimit të faturës! Provoni përsëri", "success");
                        </script>';
                    }
                }
            } else {
                $responseInvoice = '<script language="javascript">
                swal("Gabim!", "Ka ndodhur një gabim gjatë rregjistrimit të faturës! Provoni përsëri", "success");
                </script>';
            }
        }
    }
}
//register invoice\
//////// start "updating Profil of Manager"///////////////
function updateManager()
{
    if (isset($_POST['upd_manager'])) {
        global $connection;

        global $updateManagerResponse;
        $updateManagerResponse = '';
        $id_manager = $_POST['id_manager'];
        $updateManager = '';

        $upd_name = mysqli_real_escape_string($connection, $_POST['upd_name']);
        if (!empty($upd_name)) {
            $updateManager .= "name = '$upd_name',";
        }

        $upd_lastname = mysqli_real_escape_string($connection, $_POST['upd_lastname']);
        if (!empty($upd_lastname)) {
            $updateManager .= "lastname = '$upd_lastname',";
        }

        $upd_email = mysqli_real_escape_string($connection, $_POST['upd_email']);
        if (!empty($upd_email)) {
            $updateManager .= "email = '$upd_email',";
        }
        $upd_phone = mysqli_real_escape_string($connection, $_POST['upd_phone']);
        if (!empty($upd_phone)) {
            $updateManager .= "phone = '$upd_phone',";
        }
        $upd_username = mysqli_real_escape_string($connection, $_POST['upd_username']);
        if (!empty($upd_username)) {
            $updateManager .= "username = '$upd_username',";
        }
        $upd_password = mysqli_real_escape_string($connection, $_POST['upd_password']);
        if (!empty($upd_password)) {
            $updateManager .= "password = '$upd_password',";
        }

        $updateManager = rtrim($updateManager, ',');

        $query_manager = "UPDATE user SET $updateManager WHERE userId = '$id_manager'";
        $result_manager = mysqli_query($connection, $query_manager);

        if ($result_manager) {
            $updateManagerResponse = '<script language="javascript">swal("Sukses!", "Të dhënat u modifikuan!", "success")</script>';
        } else {
            $updateManagerResponse = '<script language="javascript">swal("Gabim!", "Të dhënat nuk u modifikuan", "error")';
        }
    }
}
///////////// end of "updating Profil of Manager"//////////

/******** get all dates between two dates ********/
function datePeriod_start_end($begin, $end)
{
    $begin = new DateTime($begin);

    $end = new DateTime($end.' +1 day');

    $daterange = new DatePeriod($begin, new DateInterval('P1D'), $end);

    foreach ($daterange as $date) {
        $dates[] = $date->format("Y-m-d");
    }
    return $dates;
}
/******** /.end get all dates between two dates ********/

/******** get all months between two dates ********/
function monthPeriod_start_end($begin, $end)
{
    $begin = (new DateTime($begin.'-01-01'))->modify('first day of this month');
    $end = (new DateTime($end.'-12-01 +1 month'))->modify('first day of this month');
    $daterange = new DatePeriod($begin, new DateInterval('P1M'), $end);

    foreach ($daterange as $date) {
        $dates[] = $date->format("m");
    }
    return $dates;
}
/******** /.end get all months between two dates ********/