<?php

require_once '../session-check.php';
$prod_id = $_GET['i'];

$sql = "SELECT product_photo FROM product WHERE product_id = ?";
$stmt = $connect->prepare($sql);
$stmt->bind_param("i", $prod_id);
$stmt->execute();

$result = $stmt->get_result()->fetch_row();

$connect->close();

echo "product-images/" . $result[0];
