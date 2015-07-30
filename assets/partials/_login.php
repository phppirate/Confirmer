<?php
$uname = "confirm";
$pass = "password";

if (isset($_GET['authenticate'])){
    authenticate();
}

function authenticate() {
    header('WWW-Authenticate: Basic realm="Welcome to Confirmer!"');
    header('HTTP/1.0 401 Unauthorized');
    echo "You must enter a valid login ID and password to access this resource\n";
    exit;
}
if (!isset($_SERVER['PHP_AUTH_USER']) || ($_SERVER['PHP_AUTH_USER'] != $uname || $_SERVER['PHP_AUTH_PW'] != $pass)){
    authenticate();
}
?>