<?php 

require_once 'functions/session-check.php';

// remove all session variables
session_unset(); 

// destroy the session 
session_destroy(); 

header('location: http://localhost/index.php');

?>