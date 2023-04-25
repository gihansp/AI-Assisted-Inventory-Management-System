<?php

use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    private $connection;

    public function setUp(): void
    {
        $this->connection = new mysqli("localhost", "username", "password", "database_name");

        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }

        $sql = "CREATE TABLE IF NOT EXISTS users (
            user_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            first_name VARCHAR(30) NOT NULL,
            last_name VARCHAR(30) NOT NULL,
            email VARCHAR(50) UNIQUE NOT NULL
        )";

        if ($this->connection->query($sql) === false) {
            die("Error creating table: " . $this->connection->error);
        }
    }

    public function testUserRemovalSuccess(): void
    {
        $insertUserSql = "INSERT INTO users (first_name, last_name, email) VALUES (?, ?, ?)";
        $insertUserStmt = $this->connection->prepare($insertUserSql);
        $insertUserStmt->bind_param("sss", $firstName, $lastName, $email);

        $firstName = "John";
        $lastName = "Doe";
        $email = "johndoe@example.com";

        if (!$insertUserStmt->execute()) {
            $this->fail("User insertion failed: " . $this->connection->error);
        }

        $userId = $insertUserStmt->insert_id;

        $deleteUserSql = "DELETE FROM users WHERE user_id = ?";
        $deleteUserStmt = $this->connection->prepare($deleteUserSql);
        $deleteUserStmt->bind_param("i", $userId);

        $this->assertTrue($deleteUserStmt->execute());

        $deleteUserStmt->close();
        $insertUserStmt->close();
    }

    public function testMissingUserId(): void
    {
        $response = $this->makeRequest(array());

        $this->assertEquals(false, $response['success']);
        $this->assertContains('User ID is missing', $response['messages']);
    }

    private function makeRequest($data): array
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'http://localhost/user.php');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            die('Error: ' . curl_error($ch));
        }

        curl_close($ch);

        return json_decode($response, true);
    }

    public function tearDown(): void
    {
        $
