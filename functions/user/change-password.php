<?php
require_once '../session-check.php';

if ($_POST) {
    $response = array(
        'isSuccessful' => false,
        'updateFeedback' => array()
    );

    $oldPass = md5($_POST['password']);
    $newPass = md5($_POST['new_pwd']);
    $matchPass = md5($_POST['conf_pwd']);
    $uId = $_POST['user_id'];

    $stmt = $connect->prepare("SELECT password FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $uId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        if ($oldPass === $row['password']) {
            if ($newPass === $matchPass) {
                $updateStmt = $connect->prepare("UPDATE users SET password = ? WHERE user_id = ?");
                $updateStmt->bind_param("si", $newPass, $uId);

                if ($updateStmt->execute()) {
                    $response['isSuccessful'] = true;
                    $response['updateFeedback'] = "Password updated successfully.";
                } else {
                    $response['isSuccessful'] = false;
                    $response['updateFeedback'] = "Error occurred while updating the password. Please try again later.";
                }
            } else {
                $response['isSuccessful'] = false;
                $response['updateFeedback'] = "The new password and confirm password do not match. Please ensure both passwords are identical.";
            }
        } else {
            $response['isSuccessful'] = false;
            $response['updateFeedback'] = "Incorrect current password. Please provide the correct current password.";
        }
    } else {
        $response['isSuccessful'] = false;
        $response['updateFeedback'] = "User not found. Please check the provided user information.";
    }

    $stmt->close();
    $connect->close();

    echo json_encode($response);
}
