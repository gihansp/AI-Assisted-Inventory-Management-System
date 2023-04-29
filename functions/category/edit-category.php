<?php
require_once '../session-check.php';

$response = [
    'isSuccessful' => false,
    'updateFeedback' => [],
];

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $brandName = filter_input(INPUT_POST, 'mdfy_cats_name', FILTER_SANITIZE_STRING);
        $categoriesId = filter_input(INPUT_POST, 'mdfy_cats_id', FILTER_SANITIZE_NUMBER_INT);

        if ($brandName !== null && $categoriesId !== null) {
            $stmt = $connect->prepare('UPDATE categories SET cat_name = ? WHERE cat_id = ?');
            $stmt->bind_param('si', $brandName, $categoriesId);

            if ($stmt->execute()) {
                $response['isSuccessful'] = true;
                $response['updateFeedback'] = '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span> The categories were updated successfully.';
            } else {
                $response['updateFeedback'] = '<span class="glyphicon glyphicon-alert" aria-hidden="true"></span> An error occurred while updating the categories. Please try again later.';
            }

            $stmt->close();
        } else {
            $response['updateFeedback'] = 'Invalid input.';
        }
    }

    header('Content-Type: application/json');
    echo json_encode($response);

} catch (Exception $e) {
    $response['updateFeedback'] = $e->getMessage();

    header('Content-Type: application/json');
    echo json_encode($response);
}

$connect->close();
