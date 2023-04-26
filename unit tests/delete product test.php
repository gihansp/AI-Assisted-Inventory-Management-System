<?php

use PHPUnit\Framework\TestCase;

class RemoveProductTest extends TestCase
{
    private $mockConnect;

    protected function setUp(): void
    {
        $this->mockConnect = $this->getMockBuilder(PDO::class)
                                  ->disableOriginalConstructor()
                                  ->getMock();
    }

    public function testRemoveProduct()
    {
        // Arrange
        $_POST['prod_id'] = 123;

        $stmtMock = $this->getMockBuilder(PDOStatement::class)
                         ->disableOriginalConstructor()
                         ->getMock();
        $this->mockConnect->expects($this->once())
                          ->method('prepare')
                          ->with('UPDATE product SET active = 2, status = 2 WHERE product_id = ?')
                          ->willReturn($stmtMock);

        $stmtMock->expects($this->once())
                 ->method('bind_param')
                 ->with('i', $_POST['prod_id']);

        $stmtMock->expects($this->once())
                 ->method('execute')
                 ->willReturn(true);

        $expectedResult = array('isSuccessful' => true, 'updateFeedback' => 'Product successfully removed.');

        // Act
        ob_start();
        include 'remove-product.php';
        $output = ob_get_clean();
        $actualResult = json_decode($output, true);

        // Assert
        $this->assertEquals($expectedResult, $actualResult);
    }
}
