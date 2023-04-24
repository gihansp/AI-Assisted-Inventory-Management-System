<?php
use PHPUnit\Framework\TestCase;

class CategoryTest extends TestCase
{
    public function testCategoryById()
    {
        // Mock database connection
        $connect = $this->getMockBuilder(\mysqli::class)
            ->setMethods(['prepare', 'bind_param', 'execute', 'get_result', 'close'])
            ->getMock();

        $query = $this->getMockBuilder(\mysqli_stmt::class)
            ->setMethods(['bind_param', 'execute', 'get_result', 'close'])
            ->getMock();

        $result = $this->getMockBuilder(\mysqli_result::class)
            ->setMethods(['num_rows', 'fetch_assoc'])
            ->getMock();

        $connect->expects($this->once())
            ->method('prepare')
            ->with($this->equalTo('SELECT cat_id, cat_name, cat_status FROM categories WHERE cat_id = ?'))
            ->willReturn($query);

        $query->expects($this->once())
            ->method('bind_param')
            ->with($this->equalTo('i'), $this->equalTo(1));

        $query->expects($this->once())
            ->method('execute');

        $query->expects($this->once())
            ->method('get_result')
            ->willReturn($result);

        $result->expects($this->once())
            ->method('num_rows')
            ->willReturn(1);

        $result->expects($this->once())
            ->method('fetch_assoc')
            ->willReturn([
                'cat_id' => 1,
                'cat_name' => 'TestCategory',
                'cat_status' => 'active'
            ]);

        $query->expects($this->once())
            ->method('close');

        $connect->expects($this->once())
            ->method('close');

        // Set up POST data
        $_POST['categoriesId'] = 1;

        ob_start();
        require_once '../session-check.php';
        $output = ob_get_clean();

        // Assert the expected JSON response
        $expected = json_encode([
            'cat_id' => 1,
            'cat_name' => 'TestCategory',
            'cat_status' => 'active'
        ]);
        $this->assertEquals($expected, $output);
    }
}
