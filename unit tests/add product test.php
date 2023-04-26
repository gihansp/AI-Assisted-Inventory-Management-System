<?php
<?php
require_once 'path/to/session-check.php';


class AddProductTest extends PHPUnit_Framework_TestCase {

    public function setUp() {
        // Set up a mock database connection
        $this->mockConnection = $this->getMockBuilder('mysqli')
            ->disableOriginalConstructor()
            ->getMock();
        $GLOBALS['connect'] = $this->mockConnection;
    }

    public function testAddProductSuccess() {
        // Set up POST data
        $_POST = array(
            'prod_nm' => 'Test Product',
            'product_quantity' => 10,
            'rate' => 5.99,
            'cat_nm' => 1,
            'prod_status' => 'In Stock'
        );
        $_FILES = array(
            'prod_img' => array(
                'name' => 'test.jpg',
                'tmp_name' => 'path/to/tmpfile'
            )
        );

        // Set up the expected SQL query and result
        $sql = "INSERT INTO product (product_name, product_photo, cat_id, product_quantity, rate, active, status) 
                VALUES ('Test Product', 'path/to/image.jpg', '1', '10', '5.99', 'In Stock', 1)";
        $queryResult = true;

        // Set up the mock connection to return the expected query result
        $this->mockConnection->expects($this->once())
            ->method('query')
            ->with($this->equalTo($sql))
            ->will($this->returnValue($queryResult));

        // Call the function to be tested
        ob_start();
        addProduct();
        $response = json_decode(ob_get_clean(), true);

        // Assert that the response indicates success
        $this->assertTrue($response['isSuccessful']);
        $this->assertEquals('Product successfully added.', $response['updateFeedback']);
    }

    public function testAddProductInvalidImageFormat() {
        // Set up POST data with an invalid image format
        $_POST = array(
            'prod_nm' => 'Test Product',
            'product_quantity' => 10,
            'rate' => 5.99,
            'cat_nm' => 1,
            'prod_status' => 'In Stock'
        );
        $_FILES = array(
            'prod_img' => array(
                'name' => 'test.txt',
                'tmp_name' => 'path/to/tmpfile'
            )
        );

        ob_start();
        addProduct();
        $response = json_decode(ob_get_clean(), true);

        // Assert that the response
        $this->assertFalse($response['isSuccessful']);
        $this->assertEquals('Invalid image format. Please upload an image file.', $response['updateFeedback']);
    }

}

