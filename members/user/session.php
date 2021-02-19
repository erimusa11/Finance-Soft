<?php

session_start();
include '../../functions.php';
$userId = $_SESSION['user_id'];
logout();
 if (($_SESSION['role'] != 2) || !isset($_SESSION['user_id'])) {
     header('Location: ../../index.php');
 }