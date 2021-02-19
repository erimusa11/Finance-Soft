<?php
include '../../../functions.php';
global $connection;

$userId = $_POST['userId'];

$data = array();

$query = "SELECT *
FROM user
WHERE userId= '$userId'";
$result = mysqli_query($connection, $query);
while ($row = mysqli_fetch_array($result)) {
    $username = $row['username'];
    $name = $row['name'];
    $lastname = $row['lastname'];
    $email = $row['email'];
    $phone = $row['phone'];
    $status = $row['status'];

    $data[] = array(
        'username' => $username,
        'name' => $name,
        'lastname' => $lastname,
        'email' => $email,
        'phone' => $phone,
        'status' => $status,
    );
}
echo json_encode($data);