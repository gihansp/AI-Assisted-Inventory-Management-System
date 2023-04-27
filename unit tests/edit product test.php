<?php

// Import the necessary files
require_once('../session-check.php');

// Import the file to be tested
require_once('update-product.php');

class UpdateProductTest extends PHPUnit_Framework_TestCase {

    public function testIncompleteProductInformation() {
        // Arrange
        $_POST = array(
            'prod_id' => 1,
            'mdfy_prod_nm' => '',
            'mdfy_prod_qty' => '',
            'mdfy_rate' => '',
            'mdfy_cat_nm' => '',
            'mdfy_prod_status' => ''
        );

        $expectedResponse = array(
            'isSuccessful' => false,
            'updateFeedback' => 'Incomplete product information. Please provide all required details.'
        );

        // Act
        ob_start();
        updateProduct();
        $result = ob_get_clean();

        // Assert
        $this->assertEquals(json_encode($expectedResponse), $result);
    }

    public function testProductUpdateSuccess() {
        // Arrange
        global $connect;
        $_POST = array(
            'prod_id' => 1,
            'mdfy_prod_nm' => 'Product 1',
            'mdfy_prod_qty' => 10,
            'mdfy_rate' => 100,
            'mdfy_cat_nm' => 1,
            'mdfy_prod_status' => 1
        );

        $expectedResponse = array(
            'isSuccessful' => true,
            'updateFeedback' => 'Product information successfully updated.'
        );

        // Act
        ob_start();
        updateProduct();
        $result = ob_get_clean();

        // Assert
        $this->assertEquals(json_encode($expectedResponse), $result);

        // Cleanup
        $connect->query("DELETE FROM product WHERE product_id = 1");
    }

    public function testProductUpdateFailure() {
        // Arrange
        global $connect;
        $_POST = array(
            'prod_id' => 1,
            'mdfy_prod_nm' => 'Product 1',
            'mdfy_prod_qty' => 10,
            'mdfy_rate' => 100,
            'mdfy_cat_nm' => 1,
            'mdfy_prod_status' => 1
        );

        $connect->query("INSERT INTO product (product_id, product_name, cat_id, product_quantity, rate, active, status) VALUES (1, 'Product 1', 1, 10, 100, 1, 1)");

        $expectedResponse = array(
            'isSuccessful' => false,
            'updateFeedback' => 'Error occurred while updating product information. Please try again later.'
        );

        // Act
        ob_start();
        updateProduct();
        $result = ob_get_clean();

        // Assert
        $this->assertEquals(json_encode($expectedResponse), $result);

        // Cleanup
        $connect->query("DELETE FROM product WHERE product_id = 1");
    }

}
