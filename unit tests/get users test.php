<?php

use PHPUnit\Framework\TestCase;

class UsersTest extends TestCase
{
    private $connect;

    public function setUp(): void
    {
        $this->connect = new mysqli('localhost', 'username', 'password', 'database');
    }

    public function testFetchUserById()
    {
        // Arrange
        $uId = 1;
        $expectedResult = array(
            'user_id' => 1,
            'username' => 'john_doe',
            // Add other expected values here
        );

        // Act
        $_POST['userid'] = $uId;
        ob_start();
        include 'fetch-user.php';
        $actualResult = json_decode(ob_get_clean(), true);

        // Assert
        $this->assertEquals($expectedResult, $actualResult);
    }

    public function testRemoveUserById()
    {
        // Arrange
        $uId = 1;
        $_POST['userid'] = $uId;
        $expectedResult = array(
            'isSuccessful' => true,
            'updateFeedback' => array('User successfully removed.')
        );

        // Act
        ob_start();
        include 'remove-user.php';
        $actualResult = json_decode(ob_get_clean(), true);

        // Assert
        $this->assertEquals($expectedResult, $actualResult);

        // Assert that user with the given ID is no longer in the database
        $query = $this->connect->prepare("SELECT * FROM users WHERE user_id = ?");
        $query->bind_param("i", $uId);
        $query->execute();
        $result = $query->get_result();
        $this->assertEquals(0, $result->num_rows);
    }

    public function testFetchAllUsers()
    {
        // Arrange
        $expectedResult = array(
            'data' => array(
                array(
                    'john_doe',
                    '<div class="btn-group btn-group-justified" role="group" aria-label="Justified button group">
                        <a type="button" class="btn btn-primary" data-toggle="modal" id="editUserModalBtn" data-target="#editUserModal" onclick="editUser(1)"> <i class="glyphicon glyphicon-edit"></i></a>
                        <a type="button" class="btn btn-danger" data-toggle="modal" data-target="#del_usr_modal" id="del_usr_modalBtn" onclick="deleteUser(1)"> <i class="glyphicon glyphicon-trash"></i></a>       
                    </div>'
                ),
                // Add other expected values here
            )
        );

        // Act
        ob_start();
        include 'fetch-all-users.php';
        $actualResult = json_decode(ob_get_clean(), true);

        // Assert
        $this->assertEquals($expectedResult, $actualResult);
    }

    public function tearDown(): void
    {
        $this->connect->close();
    }
}
