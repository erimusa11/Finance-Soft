<?php
session_start();
include '../../functions.php';

$userId = $_SESSION['user_id'];

if (!isset($userId) || ($_SESSION['role'] != 1)) {
    header("Location: ../../index.php");
}
logout();