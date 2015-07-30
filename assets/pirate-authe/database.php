<?php

require_once "config.php";

$mysql_server = DB_SERVER;
$mysql_username = DB_USER;
$mysql_password = DB_PASS;
$mysql_database = DB_NAME;
$connection = mysqli_connect($mysql_server, $mysql_username, $mysql_password);
mysqli_select_db($connection, $mysql_database);