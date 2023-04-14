<?php

require_once '../session-check.php';

$response = array('isSuccessful' => false, 'updateFeedback' => array());

if (isset($_POST['categoriesId'])) {
    $categoriesId = $_POST['categoriesId'];

    $sql = "UPDATE categories SET cat_status = 2 WHERE cat_id = ?";
    $stmt = $connect->prepare($sql);
    $stmt->bind_param("i", $categoriesId);

    if ($stmt->execute()) {
        $response['isSuccessful'] = true;
        $response['updateFeedback'] = "Category successfully removed.";
    } else {
        $response['isSuccessful'] = false;
        $response['updateFeedback'] = "Error occurred while removing the category. Please try again later.";
    }

    $stmt->close();
    $connect->close();

    echo json_encode($response);
}
