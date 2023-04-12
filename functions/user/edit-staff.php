<?php

require_once '../session-check.php';

$response = array('isSuccessful' => false, 'updateFeedback' => array());

try {
    if($_POST) {
        $mdfy_usr_nm = $_POST['mdfy_usr_nm'];
        $mdfy_pwd = md5($_POST['mdfy_pwd']);
        $uId = $_POST['userid'];

        $sql = "UPDATE users SET username = '$mdfy_usr_nm', password = '$mdfy_pwd' WHERE user_id = $uId ";

        if($connect->query($sql) === TRUE) {
            $response['isSuccessful'] = true;
            $response['updateFeedback'] = "User information updated successfully.";
        } else {
            $response['isSuccessful'] = false;
            $response['updateFeedback'] = "Error occurred while updating user information. Please try again later.";
        }
    }
} catch (Exception $e) {
    $response['isSuccessful'] = false;
    $response['updateFeedback'] = "Error: " . $e->getMessage();
}

$connect->close();

echo json_encode($response);
