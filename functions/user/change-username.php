<?php
require_once '../session-check.php';

if (isset($_POST['username'], $_POST['user_id'])) {
    $response = array(
        'isSuccessful' => false,
        'updateFeedback' => array()
    );

    $username = $_POST['username'];
    $uId = $_POST['user_id'];

    try {
        $stmt = $connect->prepare("UPDATE users SET username = ? WHERE user_id = ?");
        $stmt->bind_param("si", $username, $uId);

        if ($stmt->execute()) {
            $response['isSuccessful'] = true;
            $response['updateFeedback'] = "User information updated successfully.";
        } else {
            throw new Exception("Error occurred while updating user information. Please try again later.");
        }

        $stmt->close();
    } catch (Exception $e) {
        $response['isSuccessful'] = false;
        $response['updateFeedback'] = $e->getMessage();
    }

    $connect->close();

    echo json_encode($response);
}
