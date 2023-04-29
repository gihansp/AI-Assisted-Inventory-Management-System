<?php

require_once '../session-check.php';

$response = ['isSuccessful' => false, 'updateFeedback' => []];

try {
    if (!empty($_POST['prod_id']) && !empty($_FILES['mdfy_prod_img'])) {
        $prod_id = $_POST['prod_id'];
        $type = explode('.', $_FILES['mdfy_prod_img']['name']);
        $type = $type[count($type) - 1];
        $url = '../../assets/images/product-images/' . uniqid(rand()) . '.' . $type;

        $allowedImageFormats = ['gif', 'jpg', 'jpeg', 'png'];
        if (in_array(strtolower($type), $allowedImageFormats)) {
            if (is_uploaded_file($_FILES['mdfy_prod_img']['tmp_name'])) {
                if (move_uploaded_file($_FILES['mdfy_prod_img']['tmp_name'], $url)) {
                    $sql = "UPDATE product SET product_photo = '$url' WHERE product_id = $prod_id";

                    if ($connect->query($sql) === true) {
                        $response['isSuccessful'] = true;
                        $response['updateFeedback'] = "<span class='glyphicon glyphicon-ok'></span> Product image successfully updated.";
                    } else {
                        throw new Exception("<span class='glyphicon glyphicon-exclamation-sign'></span> Error occurred while updating the product image. Please try again later.");
                    }
                } else {
                    throw new Exception("<span class='glyphicon glyphicon-exclamation-sign'></span> Error occurred while moving the uploaded file. Please try again later.");
                }
            } else {
                throw new Exception("<span class='glyphicon glyphicon-exclamation-sign'></span> No file uploaded. Please upload a file.");
            }
        } else {
            throw new Exception("<span class='glyphicon glyphicon-exclamation-sign'></span> Invalid file type. Only specific file types are allowed.");
        }
    } else {
        throw new Exception("<span class='glyphicon glyphicon-exclamation-sign'></span> Product ID or edited product image is empty. Please provide the required information.");
    }
} catch (Exception $e) {
    $response['isSuccessful'] = false;
    $response['updateFeedback'] = $e->getMessage();
}

$connect->close();

echo json_encode($response);
