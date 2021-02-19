<?php
// the conection of database local host  where the datas are stored
DEFINE('DB_HOSTNAME', '81.31.151.15');
DEFINE('DB_DATABASE', 'interna5_dbcommu');
DEFINE('DB_USERNAME', 'inter_uscommu');
DEFINE('DB_PASSWORD', 'Qaaf_363');

$connection = mysqli_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
mysqli_set_charset($connection, "utf8");
date_default_timezone_set('Europe/Rome');
setlocale(LC_ALL, 'sq_AL.UTF-8');