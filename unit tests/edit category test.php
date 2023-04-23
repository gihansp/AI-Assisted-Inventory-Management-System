<?php

use PHPUnit\Framework\TestCase;

class CategoriesTest extends TestCase
{
    public function testUpdateCategories()
    {
        // Mock the POST request data
        $_POST = [
            'mdfy_cats_name' => 'New Category Name',
            'mdfy_cats_id' => 1,
        ];

        // Mock the database connection
        $connect = $this->getMockBuilder(stdClass::class)
            ->setMethods(['prepare', 'bind_param', 'execute', 'close'])
            ->getMock();

        $stmt = $this->getMockBuilder(stdClass::class)
            ->setMethods(['execute', 'close'])
            ->getMock();

        $connect->expects($this->once())
            ->method('prepare')
            ->with('UPDATE categories SET cat_name = ? WHERE cat_id = ?')
            ->willReturn($stmt);

        $stmt->expects($this->once())
            ->method('bind_param')
            ->with('si', 'New Category Name', 1);

        $stmt->expects($this->once())
            ->method('execute')
            ->willReturn(true);

        $stmt->expects($this->once())
            ->method('close');

        // Mock the session-check.php file
        require_once 'session-check.php';

        // Capture the output of the code
        ob_start();
        require 'update-categories.php';
        $output = ob_get_clean();

        // Assert the output is a valid JSON string
        $this->assertJson($output);

        // Decode the JSON string and assert the expected response values
        $response = json_decode($output, true);
        $this->assertTrue($response['isSuccessful']);
        $this->assertEquals('The categories were updated successfully.', $response['updateFeedback']);
    }
}
?>