<?php
require_once 'PHPUnit/Framework/TestCase.php';

class UserUpdateTest extends PHPUnit_Framework_TestCase
{
    private $conn;

    protected function setUp()
    {
        require_once '../config.php';
        $this->conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }

        // insert test user into the database
        $this->conn->query("INSERT INTO users (username, password, email) 
            VALUES ('testuser', 'testpass', 'testuser@example.com')");
    }

    public function testUpdateUserInformation()
    {
        $userId = $this->conn->insert_id;
        $data = array(
            'userid' => $userId,
            'mdfy_usr_nm' => 'newtestuser',
            'mdfy_pwd' => 'newtestpass'
        );

        $options = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data),
            ),
        );

        $context  = stream_context_create($options);
        $result = file_get_contents('http://localhost/user-update.php', false, $context);
        $response = json_decode($result, true);

        // check if the response is successful
        $this->assertTrue($response['isSuccessful']);

        // check if the user information is updated
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE user_id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        $this->assertEquals('newtestuser', $result->fetch_assoc()['username']);

        $stmt->close();
    }

    protected function tearDown()
    {
        // delete the test user from the database
        $this->conn->query("DELETE FROM users WHERE username = 'newtestuser'");
        $this->conn->close();
    }
}
