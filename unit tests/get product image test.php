<?php

use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{
    public function testGetProductPhoto()
    {
        require_once '../session-check.php';
        $prod_id = 1; // Set the product ID to a known value
        
        $sql = "SELECT product_photo FROM product WHERE product_id = ?";
        $stmt = $connect->prepare($sql);
        $stmt->bind_param("i", $prod_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_row();
        $stmt->close();
        $connect->close();
        
        $this->assertIsArray($result);
        $this->assertCount(1, $result); // Make sure there is only one column
        $this->assertNotEmpty($result[0]); // Make sure product_photo is not empty
        
        $expected = "product-images/" . $result[0];
        $actual = getProductPhotoUrl($prod_id); // Define this function to return the photo URL given a product ID
        $this->assertSame($expected, $actual);
    }
}
