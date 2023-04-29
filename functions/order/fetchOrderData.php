<?php

require_once '../session-check.php';
$orderId = $_POST['orderId'];

$response = array('order' => array(), 'order_item' => array());

$stmt = $connect->prepare("SELECT order_id, date_ordered, customer_name, customer_phone, total_before_tax, vat, total_invoice_amount, discount, total_amount_payable, paid, due, payment_method, payment_status FROM orders WHERE order_id = ?");
$stmt->bind_param('i', $orderId);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();
$response['order'] = $data;

$stmt->close();
$connect->close();

echo json_encode($response);
