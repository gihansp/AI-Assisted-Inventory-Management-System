<?php

require_once '../session-check.php';
$response = array('isSuccessful' => false, 'updateFeedback' => array());

if (isset($_POST['product_Id'])) {



    $productId = $_POST['product_Id'];
}