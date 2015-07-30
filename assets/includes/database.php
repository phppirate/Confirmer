<?php

require_once "config.php";

$mysql_server = DB_SERVER;
$mysql_username = DB_USER;
$mysql_password = DB_PASS;
$mysql_database = DB_NAME;
$connection = mysqli_connect($mysql_server, $mysql_username, $mysql_password);
mysqli_select_db($connection, $mysql_database);

$time = time();
$time_formatted = strftime("%r", $time);
$date_formatted = strftime("%D", $time);

$name_date = strftime("%a %B %e, %Y", $time);
$sql_date = strftime("%Y-%m-%d %H:%M:%S", $time);