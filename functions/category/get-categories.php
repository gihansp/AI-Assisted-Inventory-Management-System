<?php

require_once '../session-check.php';

$query = "SELECT cat_id, cat_name, cat_status FROM categories WHERE cat_status = ?";
$stmt = $connect->prepare($query);
$status = 1;
$stmt->bind_param("i", $status);
$stmt->execute();
$result = $stmt->get_result();

$output = ['data' => []];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $activeCategories = '';

        if ($row['cat_status'] == 1) {
            $activeCategories = "Available</label>";
        } else {
            $activeCategories = "Not Available</label>";
        }

        $button = '<div class="btn-group btn-group-justified" role="group" aria-label="Justified button group">
            <a type="button" class="btn btn-primary" data-toggle="modal" id="editCatsModalBtn" data-target="#editCatsModal" onclick="editCats('.$row['cat_id'].')"> <i class="glyphicon glyphicon-edit"></i></a>
            <a  type="button" class="btn btn-danger" data-toggle="modal" data-target="#del_cats_modal" id="del_cats_modalBtn" onclick="removeCats('.$row['cat_id'].')"> <i class="glyphicon glyphicon-trash"></i></a>       
        </div>';

        $output['data'][] = [$row['cat_name'], $button];
    }
}

$stmt->close();
$connect->close();

echo json_encode($output);

