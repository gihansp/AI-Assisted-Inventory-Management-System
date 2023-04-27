<?php
use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{
    public function testProductQuery()
    {
        require_once '../session-check.php';
        
        $sql = "SELECT * FROM product WHERE active = 1 AND status = 1 AND product_quantity != 0";
        $stmt = $connect->prepare($sql);
        $active = 1;
        $status = 1;
        $stmt->bind_param("ii", $active, $status);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_all(MYSQLI_NUM);
        $stmt->close();
        $connect->close();
        
        $this->assertIsArray($data);
        $this->assertNotEmpty($data);
        $this->assertContainsOnly('array', $data);
        $this->assertGreaterThan(0, count($data));
        
        foreach ($data as $row) {
            $this->assertIsArray($row);
            $this->assertCount(8, $row); // Make sure there are 8 columns
            $this->assertContainsOnly('string', $row);
            $this->assertNotEmpty($row[0]); // Make sure product_id is not empty
            $this->assertNotEmpty($row[1]); // Make sure product_name is not empty
            $this->assertNotEmpty($row[2]); // Make sure product_photo is not empty
            $this->assertNotEmpty($row[3]); // Make sure cat_id is not empty
            $this->assertNotEmpty($row[4]); // Make sure product_quantity is not empty
            $this->assertNotEmpty($row[5]); // Make sure rate is not empty
            $this->assertNotEmpty($row[6]); // Make sure active is not empty
            $this->assertNotEmpty($row[7]); // Make sure status is not empty
        }
    }
}

