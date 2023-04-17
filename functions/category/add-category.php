<?php
require_once '../session-check.php';

$response = [
    'isSuccessful' => false,
    'updateFeedback' => [],
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cats_name = filter_input(INPUT_POST, 'cats_name', FILTER_SANITIZE_STRING);

    if ($cats_name !== null) {
        try {
            $stmt = $connect->prepare('INSERT INTO categories (cat_name, cat_status) VALUES (?, 1)');
            $stmt->bind_param('s', $cats_name);

            if ($stmt->execute()) {
                $response['isSuccessful'] = true;
                $response['updateFeedback'] = 'Category created successfully.';
            } else {
                throw new Exception('Error occurred while creating the category. Please try again later.');
            }

            $stmt->close();

        } catch (Exception $e) {
            $response['updateFeedback'] = $e->getMessage();
        }
    } else {
        $response['updateFeedback'] = 'Invalid category name.';
    }

    header('Content-Type: application/json');
    echo json_encode($response);
}
