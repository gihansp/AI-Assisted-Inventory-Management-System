<?php

require_once '../session-check.php';

$query = $connect->prepare("SELECT * FROM users");
$query->execute();
$result = $query->get_result();

$output = array('data' => array());

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $uId = $row['user_id'];
        $username = $row['username'];

        $button = '
        <div class="btn-group btn-group-justified" role="group" aria-label="Justified button group">
            <a type="button" class="btn btn-primary" data-toggle="modal" id="editUserModalBtn" data-target="#editUserModal" onclick="editUser(' . $uId . ')"> <i class="glyphicon glyphicon-edit"></i></a>
            <a  type="button" class="btn btn-danger" data-toggle="modal" data-target="#del_usr_modal" id="del_usr_modalBtn" onclick="deleteUser(' . $uId . ')"> <i class="glyphicon glyphicon-trash"></i></a>       
        </div>';

        $output['data'][] = array(
            $username,
            $button
        );
    }
}

$query->close();
$connect->close();

echo json_encode($output);

