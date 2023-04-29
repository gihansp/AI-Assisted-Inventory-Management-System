<?php

require_once '../session-check.php';
$response = array('isSuccessful' => false, 'updateFeedback' => array());

if (isset($_POST['prod_id'])) {
    $prod_id = $_POST['prod_id'];

    $sql = "UPDATE product SET active = 2, status = 2 WHERE product_id = ?";
    $stmt = $connect->prepare($sql);
    $stmt->bind_param("i", $prod_id);

    if ($stmt->execute()) {
        $response['isSuccessful'] = true;
        $response['updateFeedback'] = "<span class='glyphicon glyphicon-ok'></span> Product successfully removed.";
    } else {
        $response['isSuccessful'] = false;
        $response['updateFeedback'] = "<span class='glyphicon glyphicon-exclamation-sign'></span> Error occurred while removing the product. Please try again later.";
    }

    $stmt->close();
    $connect->close();

    echo json_encode($response);
}
