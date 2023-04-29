<?php

require_once '../session-check.php';

$response['isSuccessful'] = ['isSuccessful' => false, 'updateFeedback' => []];

if ($_POST) {
    $prod_id = $_POST['prod_id'];
    $prod_nm = isset($_POST['mdfy_prod_nm']) ? $_POST['mdfy_prod_nm'] : null;
    $productQuantity = isset($_POST['mdfy_prod_qty']) ? $_POST['mdfy_prod_qty'] : null;
    $rate = isset($_POST['mdfy_rate']) ? $_POST['mdfy_rate'] : null;
    $cat_nm = isset($_POST['mdfy_cat_nm']) ? $_POST['mdfy_cat_nm'] : null;
    $prod_status = isset($_POST['mdfy_prod_status']) ? $_POST['mdfy_prod_status'] : null;

    try {
        if (!$prod_nm || !$productQuantity || !$rate || !$cat_nm || !$prod_status) {
            throw new Exception("<span class='glyphicon glyphicon-exclamation-sign'></span> Incomplete product information. Please provide all required details.");
        }

        $sql = "UPDATE product SET product_name = '$prod_nm', cat_id = '$cat_nm', product_quantity = '$productQuantity', rate = '$rate', active = '$prod_status', status = 1 WHERE product_id = $prod_id";

        if ($connect->query($sql) === TRUE) {
            $response['isSuccessful'] = true;
            $response['updateFeedback'] = "<span class='glyphicon glyphicon-ok'></span> Product information successfully updated.";
        } else {
            throw new Exception("<span class='glyphicon glyphicon-exclamation-sign'></span> Error occurred while updating product information. Please try again later.");
        }
    } catch (Exception $e) {
        $response['isSuccessful'] = false;
        $response['updateFeedback'] = $e->getMessage();
    }
}

$connect->close();

echo json_encode($response);
