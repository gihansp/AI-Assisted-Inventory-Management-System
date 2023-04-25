<?php

use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{
    private $connection;

    public function setUp(): void
    {
        $this->connection = new mysqli("localhost", "username", "password", "database_name");

        if ($this->connection->connect_error) {
            throw new Exception("Connection failed: " . $this->connection->connect_error);
        }

        $sql = "CREATE TABLE IF NOT EXISTS product (
            product_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            product_name VARCHAR(30) NOT NULL,
            active INT(1) DEFAULT 1,
            status INT(1) DEFAULT 1
        )";

        if ($this->connection->query($sql) === false) {
            throw new Exception("Error creating table: " . $this->connection->error);
        }
    }

    public function testProductRemovalSuccess(): void
    {
        $insertProductSql = "INSERT INTO product (product_name) VALUES (?)";
        $insertProductStmt = $this->connection->prepare($insertProductSql);
        $insertProductStmt->bind_param("s", $productName);

        $productName = "Test Product";

        if (!$insertProductStmt->execute()) {
            throw new Exception("Product insertion failed: " . $this->connection->error);
        }

        $productId = $insertProductStmt->insert_id;

        $updateProductSql = "UPDATE product SET active = 2, status = 2 WHERE product_id = ?";
        $updateProductStmt = $this->connection->prepare($updateProductSql);
        $updateProductStmt->bind_param("i", $productId);

        $this->assertTrue($updateProductStmt->execute());

        $updateProductStmt->close();
        $insertProductStmt->close();
    }

    public function testMissingProductId(): void
    {
        $data = array('product_id' => '');
        $response = $this->makeRequest($data);

        $this->assertEquals(false, $response['success']);
        $this->assertContains('Product ID is missing', $response['messages']);
    }

    private function makeRequest($data): array
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'http://localhost/product.php');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            throw new Exception('Error: ' . curl_error($ch));
        }

        curl_close($ch);

        return json_decode($response, true);
    }

    public function tearDown(): void
    {
        $this->connection->query("DROP TABLE IF EXISTS product");
        $this->connection->close();
    }
}
