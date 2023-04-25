<?php

require_once '../session-check.php';

$response['isSuccessful'] = [
    'isSuccessful' => false,
    'updateFeedback' => [],
    'order_id' => ''
];

if ($_POST) {
    $dateOfOrder = date('Y-m-d', strtotime($_POST['ord_date']));
    $customerName = $_POST['cstmr_nm'];
    $customerContact = $_POST['cstmr_contact'];
    $subtotalAmount = $_POST['subtot_val'];
    $taxAmount = $_POST['vatValue'];
    $billtot_val = $_POST['totalAmountValue'];
    $discountAmount = $_POST['discount'];
    $finalTotal = $_POST['grandtot_val'];
    $amountPaid = $_POST['paid'];
    $paymentDue = $_POST['dueValue'];
    $typeOfPayment = $_POST['pay_type'];
    $pay_status = $_POST['pay_status'];
    $uId = $_SESSION['userId'];

    $sql = "INSERT INTO orders (date_ordered, customer_name, customer_phone, total_before_tax, vat, total_invoice_amount, discount, total_amount_payable, paid, due, payment_method, payment_status, order_status, user_id)
    VALUES ('$dateOfOrder', '$customerName', '$customerContact', '$subtotalAmount', '$taxAmount', '$billtot_val', '$discountAmount', '$finalTotal', '$amountPaid', '$paymentDue', $typeOfPayment, $pay_status, 1, $uId)";

    $order_id;
    $orderStatus = false;

    if ($connect->query($sql) === true) {
        $order_id = $connect->insert_id;
        $response['order_id'] = $order_id;
        $orderStatus = true;
    }

    $transactionItemsStatus = false;
    $count = count($_POST['prod_nm']);

    for ($x = 0; $x < $count; $x++) {
        $prod_id = $_POST['prod_nm'][$x];
        $productQuantity = $_POST['product_quantity'][$x];
        $rate_val = $_POST['rate_val'][$x];
        $tot_val = $_POST['tot_val'][$x];

        $updateProductQuantitySql = "UPDATE product SET product_quantity = product_quantity - $productQuantity WHERE product_id = $prod_id";
        $connect->query($updateProductQuantitySql);

        $insertOrderItemSql = "INSERT INTO order_item (order_id, product_id, product_quantity, rate, total, order_item_status)
        VALUES ('$order_id', '$prod_id', '$productQuantity', '$rate_val', '$tot_val', 1)";
        $connect->query($insertOrderItemSql);
    }

    $transactionItemsStatus = ($count > 0);

    $response['isSuccessful'] = true;
    $response['updateFeedback'] = "Your order has been successfully placed.";

    $connect->close();

    echo json_encode($response);
}
