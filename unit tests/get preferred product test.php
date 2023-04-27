<?php

require_once 'PHPUnit/Framework/TestCase.php';
require_once 'path/to/session-check.php';

class ProductTest extends PHPUnit_Framework_TestCase
{
    protected static $connect;

    public static function setUpBeforeClass()
    {
        self::$connect = new mysqli('localhost', 'username', 'password', 'database_name');
    }

    public static function tearDownAfterClass()
    {
        self::$connect->close();
    }

    public function testProductInfoRetrieval()
    {
        $prod_id = 1;

        $query = self::$connect->prepare("SELECT product_id, product_name, product_photo, cat_id, product_quantity, rate, active, status FROM product WHERE product_id = ?");
        $query->bind_param("i", $prod_id);
        $query->execute();

        $result = $query->get_result();

        $this->assertTrue($result->num_rows > 0, 'Product information not found in database.');

        $row = $result->fetch_assoc();
        $this->assertArrayHasKey('product_id', $row, 'Product ID not found in query result.');
        $this->assertArrayHasKey('product_name', $row, 'Product name not found in query result.');
        $this->assertArrayHasKey('product_photo', $row, 'Product photo not found in query result.');
        $this->assertArrayHasKey('cat_id', $row, 'Category ID not found in query result.');
        $this->assertArrayHasKey('product_quantity', $row, 'Product quantity not found in query result.');
        $this->assertArrayHasKey('rate', $row, 'Product rate not found in query result.');
        $this->assertArrayHasKey('active', $row, 'Product active status not found in query result.');
        $this->assertArrayHasKey('status', $row, 'Product status not found in query result.');

        $query->close();
    }
}
