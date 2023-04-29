<?php

require_once '../session-check.php';

$response = array('isSuccessful' => false, 'updateFeedback' => array());

if (isset($_POST['userid'])) {
    $uId = $_POST['userid'];

    $sql = "DELETE FROM users WHERE user_id = ?";
    $stmt = $connect->prepare($sql);
    $stmt->bind_param("i", $uId);

    if ($stmt->execute()) {
        $response['isSuccessful'] = true;
        $response['updateFeedback'][] = "<span class='glyphicon glyphicon-ok-sign'></span> User successfully removed.";
    } else {
        $response['updateFeedback'][] = "<span class='glyphicon glyphicon-warning-sign'></span> Error occurred while removing the user. Please try again later.";
    }

    $stmt->close();
    $connect->close();
} else {
    $response['updateFeedback'][] = "<span class='glyphicon glyphicon-exclamation-sign'></span> User ID is missing. Please provide a valid user ID.";
}

echo json_encode($response);
