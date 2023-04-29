<?php

require_once '../session-check.php';

$response = array('isSuccessful' => false, 'updateFeedback' => array());

if(isset($_POST['userName'], $_POST['upassword'], $_POST['uemail'])) {
    $userName = $_POST['userName'];
    $upassword = md5($_POST['upassword']);
    $uemail = $_POST['uemail'];

    try {
        $sql = "INSERT INTO users (username, password, email) 
            VALUES (?, ?, ?)";
        $stmt = $connect->prepare($sql);
        $stmt->bind_param("sss", $userName, $upassword, $uemail);

        if($stmt->execute()) {
            $response['isSuccessful'] = true;
            $response['updateFeedback'] = "<span class='glyphicon glyphicon-ok'></span> Member added successfully.";
        } else {
            $response['isSuccessful'] = false;
            $response['updateFeedback'] = "<span class='glyphicon glyphicon-exclamation-sign'></span> Error occurred while adding the member. Please try again later.";
        }
        $stmt->close();

    } catch (Exception $e) {
        $response['isSuccessful'] = false;
        $response['updateFeedback'] = "<span class='glyphicon glyphicon-exclamation-sign'></span> Error occurred while adding the member: " . $e->getMessage();
    }
}

$connect->close();

echo json_encode($response);
