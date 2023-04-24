<?php

require_once '../session-check.php';

$response = [];

if (isset($_POST['categoriesId'])) {
    $categoriesId = $_POST['categoriesId'];

    $query = $connect->prepare("SELECT cat_id, cat_name, cat_status FROM categories WHERE cat_id = ?");
    $query->bind_param("i", $categoriesId);
    $query->execute();

    $result = $query->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $response = $row;
    } else {
        $response = ['error' => 'Category not found.'];
    }

    $query->close();
    $connect->close();

    echo json_encode($response);
}
