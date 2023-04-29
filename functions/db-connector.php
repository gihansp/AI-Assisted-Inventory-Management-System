<?php

$localhost = "localhost";
$username = "root";
$password = "root";
$dbname = "phoenix";
$port = 3306;

// db connection
$connect = new mysqli($localhost, $username, $password, $dbname, $port);
// check connection
if ($connect->connect_errno) {
    die("Connection Failed : " . $connect->connect_error);
} else {
    // echo "Successfully connected";
}

?>