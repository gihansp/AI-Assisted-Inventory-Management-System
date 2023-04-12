<?php

require_once '../session-check.php';

$uId = $_POST['userid'];

$query = $connect->prepare("SELECT * FROM users WHERE user_id = ?");
$query->bind_param("i", $uId);
$query->execute();

$result = $query->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
}

$query->close();
$connect->close();

echo json_encode($row);
