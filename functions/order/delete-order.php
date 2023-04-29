<?php

require_once '../session-check.php';
$response = array('isSuccessful' => false, 'updateFeedback' => array());

if (isset($_POST['orderId'])) {
    $orderId = $_POST['orderId'];

    $sql1 = "UPDATE orders SET order_status = 2 WHERE order_id = ?";
    $stmt1 = $connect->prepare($sql1);
    $stmt1->bind_param("i", $orderId);

    $sql2 = "UPDATE order_item SET order_item_status = 2 WHERE order_id = ?";
    $stmt2 = $connect->prepare($sql2);
    $stmt2->bind_param("i", $orderId);

    if ($stmt1->execute() && $stmt2->execute()) {
        $response['isSuccessful'] = true;
        $response['updateFeedback'] = "<span class='glyphicon glyphicon-ok'></span> The order has been successfully removed from our system.";
    } else {
        $response['isSuccessful'] = false;
        $response['updateFeedback'] = "<span class='glyphicon glyphicon-exclamation-sign'></span> Oops! Something went wrong while removing your order. Please try again later.";
    }

    $stmt1->close();
    $stmt2->close();
    $connect->close();

    echo json_encode($response);
}
