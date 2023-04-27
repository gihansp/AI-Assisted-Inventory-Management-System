<?php
public function testGetProductPhotoPath()
{
    // Set up a mock database connection
    $connect = $this->getMockBuilder(mysqli::class)
        ->setConstructorArgs(['localhost', 'username', 'password', 'database'])
        ->getMock();

    // Mock the prepare method to return a prepared statement
    $stmt = $this->getMockBuilder(mysqli_stmt::class)
        ->setConstructorArgs([$connect, 'SELECT product_photo FROM product WHERE product_id = ?'])
        ->getMock();
    $connect->expects($this->once())
        ->method('prepare')
        ->with('SELECT product_photo FROM product WHERE product_id = ?')
        ->willReturn($stmt);

    // Mock the bind_param and execute methods to return a result
    $stmt->expects($this->once())
        ->method('bind_param')
        ->with('i', 123)
        ->willReturn(true);
    $stmt->expects($this->once())
        ->method('execute')
        ->willReturn(true);

    // Mock the get_result method to return a result set with a single row
    $result_set = $this->getMockBuilder(mysqli_result::class)
        ->setConstructorArgs([$connect])
        ->getMock();
    $result_set->expects($this->once())
        ->method('fetch_row')
        ->willReturn(['product.jpg']);
    $stmt->expects($this->once())
        ->method('get_result')
        ->willReturn($result_set);

    // Call the function with a product ID of 123 and assert that the correct path is returned
    $result = getProductPhotoPath($connect, 123);
    $this->assertEquals('product-images/product.jpg', $result);
}

