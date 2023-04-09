<?php
require_once '../session-check.php';

$query = "SELECT order_id, date_ordered, customer_name, customer_phone, payment_status FROM orders WHERE order_status = ?";
$stmt = $connect->prepare($query);
$status = 1;
$stmt->bind_param("i", $status);
$stmt->execute();
$result = $stmt->get_result();

if ($result) {
    $data = array();
    while ($row = $result->fetch_assoc()) {
        $orderId = $row['order_id'];
        $countOrderItemSql = "SELECT count(*) FROM order_item WHERE order_id = ?";
        $countOrderItemStmt = $connect->prepare($countOrderItemSql);
        $countOrderItemStmt->bind_param("i", $orderId);
        $countOrderItemStmt->execute();
        $itemCountResult = $countOrderItemStmt->get_result();
        $itemCountRow = $itemCountResult->fetch_row();

        if ($row['payment_status'] == 1) {
            $pay_status = "<label>Full Payment</label>";
        } else if ($row['payment_status'] == 2) {
            $pay_status = "<label>Advance Payment</label>";
        } else {
            $pay_status = "<label>Partial Payment</label>";
        }

        $button = '<div class="btn-group btn-group-justified">
            <a type="button" class="btn btn-success"  onclick="printOrd('.$orderId.')"> <i class="glyphicon glyphicon-print"></i></a></li>
            <a type="button" class="btn btn-danger"  data-toggle="modal" data-target="#deleteOrderModal" id="deleteOrderModalBtn" onclick="deleteOrder('.$orderId.')"> <i class="glyphicon glyphicon-trash"></i></a></li>       
        </div>';

        $data[] = array(
            $row['order_id'],
            $row['date_ordered'],
            $row['customer_name'],
            $row['customer_phone'],
            $itemCountRow[0],
            $pay_status,
            $button
        );

        $countOrderItemStmt->close();
    }
    $result->free();
}

$stmt->close();
$connect->close();

echo json_encode(array('data' => $data));