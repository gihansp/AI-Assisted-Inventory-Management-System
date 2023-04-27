<?php
use PHPUnit\Framework\TestCase;

class PasswordUpdateTest extends TestCase
{
    private $connect;

    protected function setUp(): void
    {
        // initialize database connection
        $this->connect = new mysqli('localhost', 'username', 'password', 'database_name');
    }

    protected function tearDown(): void
    {
        // close database connection
        $this->connect->close();
    }

    public function testPasswordUpdateSuccess(): void
    {
        // insert a user with a known password into the database
        $password = md5('password');
        $sql = "INSERT INTO users (user_id, password) VALUES (1, '$password')";
        $this->connect->query($sql);

        // simulate a password update request
        $_POST = [
            'user_id' => 1,
            'password' => 'password',
            'new_pwd' => 'new_password',
            'conf_pwd' => 'new_password',
        ];
        ob_start();
        include 'password-update.php';
        $output = ob_get_clean();

        // check that the response indicates success
        $response = json_decode($output, true);
        $this->assertTrue($response['isSuccessful']);
        $this->assertEquals('Password updated successfully.', $response['updateFeedback']);

        // check that the user's password has been updated in the database
        $sql = "SELECT password FROM users WHERE user_id = 1";
        $result = $this->connect->query($sql);
        $this->assertEquals(1, $result->num_rows);
        $row = $result->fetch_assoc();
        $this->assertEquals(md5('new_password'), $row['password']);
    }

    public function testPasswordUpdateFailure(): void
    {
        // simulate a password update request for a non-existent user
        $_POST = [
            'user_id' => 999,
            'password' => 'password',
            'new_pwd' => 'new_password',
            'conf_pwd' => 'new_password',
        ];
        ob_start();
        include 'password-update.php';
        $output = ob_get_clean();

        // check that the response indicates failure
        $response = json_decode($output, true);
        $this->assertFalse($response['isSuccessful']);
        $this->assertEquals('User not found. Please check the provided user information.', $response['updateFeedback']);
    }
}

