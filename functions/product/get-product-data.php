<?php
require_once '../session-check.php';
$sql = "SELECT * FROM product WHERE active = 1 AND status = 1 AND product_quantity != 0";
$stmt = $connect->prepare($sql);
$active = 1;
$status = 1;
$stmt->bind_param("ii", $active, $status);
$stmt->execute();
$result = $stmt->get_result();

$data = $result->fetch_all(MYSQLI_NUM);

$stmt->close();
$connect->close();

echo json_encode($data);

