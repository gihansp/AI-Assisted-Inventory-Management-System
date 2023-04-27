<?php

// Include the code snippet being tested
require_once 'update-product-image.php';

// Define a mock connection to the database
class MockConnection {
    public function query($sql) {
        // Return true to simulate successful database update
        return true;
    }
    public function close() {}
}

// Set up the test case
class UpdateProductImageTest extends PHPUnit_Framework_TestCase {
    public function testUpdateProductImage() {
        // Arrange
        global $connect;
        $connect = new MockConnection();

        $_POST['prod_id'] = 123;

        $_FILES['mdfy_prod_img'] = [
            'name' => 'product-image.jpg',
            'type' => 'image/jpeg',
            'tmp_name' => '/tmp/php8nIwB8',
            'error' => 0,
            'size' => 202598
        ];

        // Act
        ob_start();
        updateProductImage();
        $output = ob_get_clean();

        $response = json_decode($output, true);

        // Assert
        $this->assertTrue($response['isSuccessful']);
        $this->assertEquals('Product image successfully updated.', $response['updateFeedback']);
    }
}
