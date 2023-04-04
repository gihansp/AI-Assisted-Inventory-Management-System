<?php 

session_start();

require_once 'db-connector.php';

// echo $_SESSION['userId'];

if(!$_SESSION['userId']) {
	header('location: http://localhost/index.php');
}



?>