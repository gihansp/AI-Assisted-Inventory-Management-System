<?php
session_start();

require_once 'db-connector.php';

// Check if the user is authenticated
if (!isset($_SESSION['userId']) || empty($_SESSION['userId'])) {
    header('Location: http://localhost/index.php');
    exit();
}
?>
