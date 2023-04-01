<?php
$productCount = $connect->query("SELECT COUNT(*) FROM product WHERE status = 1")->fetch_row()[0];
$orderCount = $connect->query("SELECT COUNT(*) FROM orders WHERE order_status = 1")->fetch_row()[0];
$totalRevenue = $connect->query("SELECT SUM(paid) FROM orders WHERE order_status = 1")->fetch_row()[0];
$lowStockCount = $connect->query("SELECT COUNT(*) FROM product WHERE product_quantity <= 3 AND status = 1")->fetch_row()[0];
$userOrdersQuery = $connect->query("SELECT users.username, SUM(orders.total_amount_payable) as totalorder FROM orders INNER JOIN users ON orders.user_id = users.user_id WHERE orders.order_status = 1 GROUP BY orders.user_id");
$userOrdersQuery2 = $connect->query("SELECT users.username, SUM(orders.total_amount_payable) as totalorder FROM orders INNER JOIN users ON orders.user_id = users.user_id WHERE orders.order_status = 1 GROUP BY orders.user_id");
$userOrderCount = $userOrdersQuery->num_rows;
$recentOrdersQuery = $connect->query("SELECT * FROM orders WHERE order_status = 1 ORDER BY date_ordered DESC LIMIT 5");

$connect->close();
$chartData = array();
while ($row = $userOrdersQuery2->fetch_assoc()) {
    $chartData[$row['username']] = $row['totalorder'];
}
$chartDataJson = json_encode($chartData);



?>