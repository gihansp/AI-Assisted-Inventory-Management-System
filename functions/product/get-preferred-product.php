<?php

require_once '../session-check.php';
$prod_id = $_POST['prod_id'];

$query = $connect->prepare("SELECT product_id, product_name, product_photo, cat_id, product_quantity, rate, active, status FROM product WHERE product_id = ?");
$query->bind_param("i", $prod_id);
$query->execute();

$result = $query->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
}

$query->close();
$connect->close();

echo json_encode($row);
