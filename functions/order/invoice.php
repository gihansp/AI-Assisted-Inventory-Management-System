<?php
require_once '../session-check.php';
$orderId = $_POST['orderId'];

$sql = "SELECT date_ordered, customer_name, customer_phone, total_before_tax, vat, total_invoice_amount, discount, total_amount_payable, paid, due FROM orders WHERE order_id = $orderId";

$orderResult = $connect->query($sql);
$transactionData = $orderResult->fetch_array();

$dateOfOrder = $transactionData[0];
$customerName = $transactionData[1];
$customerContact = $transactionData[2];
$subTotal = $transactionData[3];
$vat = $transactionData[4];
$totalAmount = $transactionData[5];
$discountAmount = $transactionData[6];
$finalTotal = $transactionData[7];
$amountPaid = $transactionData[8];
$due = $transactionData[9];
$gstn = $transactionData[11];

$transactionItemsSql = "SELECT order_item.product_id, order_item.rate, order_item.product_quantity, order_item.total,
product.product_name FROM order_item
   INNER JOIN product ON order_item.product_id = product.product_id 
 WHERE order_item.order_id = $orderId";
$transactionItemsResult = $connect->query($transactionItemsSql);

$table = '<h1 style="text-align: center;">Invoice</h1>';
$table .= '<table style="width: 100%;">
  <tr style="background: #343a40; color: white;">
    <th style="padding: 10px; border: 1px solid white;">Date of Order</th>
    <th style="padding: 10px; border: 1px solid white;">Customer Name</th>
    <th style="padding: 10px; border: 1px solid white;">Customer Contact</th>
    <th style="padding: 10px; border: 1px solid white;">Sub Total</th>
    <th style="padding: 10px; border: 1px solid white;">VAT</th>
    <th style="padding: 10px; border: 1px solid white;">Total Amount</th>
    <th style="padding: 10px; border: 1px solid white;">Discount Amount</th>
    <th style="padding: 10px; border: 1px solid white;">Final Total</th>
  </tr>
  <tr>
    <td style="padding: 10px; border: 1px solid black;">' . $dateOfOrder . '</td>
    <td style="padding: 10px; border: 1px solid black;">' . $customerName . '</td>
    <td style="padding: 10px; border: 1px solid black;">' . $customerContact . '</td>
    <td style="padding: 10px; border: 1px solid black;">' . $subTotal . '</td>
    <td style="padding: 10px; border: 1px solid black;">' . $vat . '</td>
    <td style="padding: 10px; border: 1px solid black;">' . $totalAmount . '</td>
    <td style="padding: 10px; border: 1px solid black;">' . $discountAmount . '</td>
    <td style="padding: 10px; border: 1px solid black;">' . $finalTotal . '</td>
  </tr>
</table>';


$table .= '<h3 style="text-align: center;">Product Details</h3>';
$table .= '<table style="width: 100%; margin-top: 20px;">
  <tr style="background: #343a40; color: white;">
    <th style="padding: 10px; border: 1px solid white;">No.</th>
    <th style="padding: 10px; border: 1px solid white;">Product Name</th>
    <th style="padding: 10px; border: 1px solid white;">Quantity</th>
    <th style="padding: 10px; border: 1px solid white;">Rate</th>
    <th style="padding: 10px; border: 1px solid white;">Total</th>
  </tr>';

$x = 1;
$cgst = 0;
$igst = 0;
$total = $subTotal + 2 * $cgst + $igst;
while($row = $transactionItemsResult->fetch_array()) {
    $table .= '<tr>
    <td style="padding: 10px; border: 1px solid black;">' . $x . '</td>
    <td style="padding: 10px; border: 1px solid black;">' . $row[4] . '</td>
    <td style="padding: 10px; border: 1px solid black;">' . $row[2] . '</td>
    <td style="padding: 10px; border: 1px solid black;">' . $row[1] . '</td>
    <td style="padding: 10px; border: 1px solid black;">' . $row[3] . '</td>
  </tr>';
    $x++;
}

$table .= '</table>';


$connect->close();

echo $table;
?>

