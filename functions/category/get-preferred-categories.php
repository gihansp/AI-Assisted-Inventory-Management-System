<?php

require_once '../session-check.php';

$categoriesId = $_POST['categoriesId'];

$query = $connect->prepare("SELECT cat_id, cat_name, cat_status FROM categories WHERE cat_id = ?");
$query->bind_param("i", $categoriesId);
$query->execute();

$result = $query->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
}

$query->close();
$connect->close();

echo json_encode($row);
