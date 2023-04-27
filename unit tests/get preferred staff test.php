<?php
require_once 'PHPUnit\Framework\TestCase.php';
require_once 'path/to/session-check.php';

class UserTest extends PHPUnit_Framework_TestCase
{
    public function testGetUserById()
    {
        // Mock the $_POST variable to simulate a form submission
        $_POST['userid'] = 1;

        // Mock the database connection
        $connect = $this->getMockBuilder('mysqli')
                        ->disableOriginalConstructor()
                        ->getMock();
        $query = $this->getMockBuilder('mysqli_stmt')
                      ->disableOriginalConstructor()
                      ->getMock();
        $result = $this->getMockBuilder('mysqli_result')
                       ->disableOriginalConstructor()
                       ->getMock();

        // Set up the expected calls to the mocked objects
        $connect->expects($this->once())
                ->method('prepare')
                ->with($this->equalTo('SELECT * FROM users WHERE user_id = ?'))
                ->willReturn($query);

        $query->expects($this->once())
              ->method('bind_param')
              ->with($this->equalTo('i'), $this->equalTo(1))
              ->willReturn(true);

        $query->expects($this->once())
              ->method('execute')
              ->willReturn(true);

        $query->expects($this->once())
              ->method('get_result')
              ->willReturn($result);

        $result->expects($this->once())
               ->method('num_rows')
               ->willReturn(1);

        $result->expects($this->once())
               ->method('fetch_assoc')
               ->willReturn(array('user_id' => 1, 'username' => 'testuser'));

        $query->expects($this->once())
              ->method('close')
              ->willReturn(true);

        $connect->expects($this->once())
                ->method('close')
                ->willReturn(true);

        // Call the function and assert the result
        ob_start();
        $this->assertEquals('{"user_id":1,"username":"testuser"}', json_encode(get_user_by_id($connect)));
        $output = ob_get_clean();
        $this->expectOutputString($output);
    }
}
