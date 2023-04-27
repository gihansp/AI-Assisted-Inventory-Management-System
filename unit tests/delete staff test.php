<?php

require_once 'PHPUnit\Framework\TestCase.php';
require_once 'path/to/session-check.php';

class UserTest extends PHPUnit_Framework_TestCase
{
    public function testDeleteUserById()
    {
        // Mock the $_POST variable to simulate a form submission
        $_POST['userid'] = 1;

        // Mock the database connection
        $connect = $this->getMockBuilder('mysqli')
                        ->disableOriginalConstructor()
                        ->getMock();
        $stmt = $this->getMockBuilder('mysqli_stmt')
                     ->disableOriginalConstructor()
                     ->getMock();

        // Set up the expected calls to the mocked objects
        $connect->expects($this->once())
                ->method('prepare')
                ->with($this->equalTo('DELETE FROM users WHERE user_id = ?'))
                ->willReturn($stmt);

        $stmt->expects($this->once())
             ->method('bind_param')
             ->with($this->equalTo('i'), $this->equalTo(1))
             ->willReturn(true);

        $stmt->expects($this->once())
             ->method('execute')
             ->willReturn(true);

        $stmt->expects($this->once())
             ->method('close')
             ->willReturn(true);

        $connect->expects($this->once())
                ->method('close')
                ->willReturn(true);

        // Call the function and assert the result
        ob_start();
        $this->assertEquals('{"isSuccessful":true,"updateFeedback":["User successfully removed."]}', json_encode(delete_user_by_id($connect)));
        $output = ob_get_clean();
        $this->expectOutputString($output);
    }

    public function testDeleteUserByIdMissingId()
    {
        // Mock the $_POST variable to simulate a form submission without a user ID
        $_POST = array();

        // Call the function and assert the result
        ob_start();
        $this->assertEquals('{"isSuccessful":false,"updateFeedback":["User ID is missing. Please provide a valid user ID."]}', json_encode(delete_user_by_id($connect)));
        $output = ob_get_clean();
        $this->expectOutputString($output);
    }
}
