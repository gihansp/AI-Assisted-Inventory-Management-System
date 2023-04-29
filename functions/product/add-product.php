<?php
require_once '../session-check.php';

$response = ['isSuccessful' => false, 'updateFeedback' => []];

if ($_POST) {
    try {
        $prod_nm = $_POST['prod_nm'];
        $productQuantity = $_POST['product_quantity'];
        $rate = $_POST['rate'];
        $cat_nm = $_POST['cat_nm'];
        $prod_status = $_POST['prod_status'];

        $type = explode('.', $_FILES['prod_img']['name']);
        $type = $type[count($type) - 1];
        $url = '../../assets/images/product-images/' . uniqid(rand()) . '.' . $type;

        $allowedImageFormats = ['gif', 'jpg', 'jpeg', 'png'];
        if (!in_array(strtolower($type), $allowedImageFormats)) {
            throw new Exception("<span class='glyphicon glyphicon-exclamation-sign'></span> Invalid image format. Please upload an image file.");
        }

        if (!is_uploaded_file($_FILES['prod_img']['tmp_name'])) {
            throw new Exception("<span class='glyphicon glyphicon-exclamation-sign'></span> File not uploaded. Please select a file to upload.");
        }

        if (!move_uploaded_file($_FILES['prod_img']['tmp_name'], $url)) {
            throw new Exception("<span class='glyphicon glyphicon-exclamation-sign'></span> Failed to move the uploaded file. Please try again later.");
        }

        $sql = "INSERT INTO product (product_name, product_photo, cat_id, product_quantity, rate, active, status) 
        VALUES ('$prod_nm', '$url', '$cat_nm', '$productQuantity', '$rate', '$prod_status', 1)";

        if ($connect->query($sql) === TRUE) {
            $response['isSuccessful'] = true;
            $response['updateFeedback'] = "<span class='glyphicon glyphicon-ok'></span> Product successfully added.";
        } else {
            throw new Exception("<span class='glyphicon glyphicon-exclamation-sign'></span> Failed to add the product. Please try again later.");
        }
    } catch (Exception $e) {
        $response['isSuccessful'] = false;
        $response['updateFeedback'] = $e->getMessage();
    }

    $connect->close();

    echo json_encode($response);
}
