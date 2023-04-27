<?php

public function testAddUser()
{
    // Set up a mock database connection
    $connect = $this->getMockBuilder(mysqli::class)
        ->setConstructorArgs(['localhost', 'username', 'password', 'database'])
        ->getMock();

    // Mock the prepare method to return a prepared statement
    $stmt = $this->getMockBuilder(mysqli_stmt::class)
        ->setConstructorArgs([$connect, 'INSERT INTO users (username, password, email) VALUES (?, ?, ?)'])
        ->getMock();
    $connect->expects($this->once())
        ->method('prepare')
        ->with('INSERT INTO users (username, password, email) VALUES (?, ?, ?)')
        ->willReturn($stmt);

    // Mock the bind_param and execute methods to return a result
    $stmt->expects($this->once())
        ->method('bind_param')
        ->with('sss', 'johndoe', md5('password'), 'johndoe@example.com')
        ->willReturn(true);
    $stmt->expects($this->once())
        ->method('execute')
        ->willReturn(true);

    // Call the function with sample data and assert that the correct response is returned
    $_POST['userName'] = 'johndoe';
    $_POST['upassword'] = 'password';
    $_POST['uemail'] = 'johndoe@example.com';
    $expected_response = array('isSuccessful' => true, 'updateFeedback' => 'Member added successfully.');
    $result = addUser($connect);
    $this->assertEquals(json_encode($expected_response), json_encode($result));
}


$connect->close();

echo json_encode($response);
