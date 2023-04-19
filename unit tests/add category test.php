<?php

use PHPUnit\Framework\TestCase;

class CreateCategoryTest extends TestCase
{
    public function testCreateCategory()
    {
        // Arrange
        $cats_name = 'TestCategory';
        $connect = $this->createMock(mysqli::class);
        $stmt = $this->createMock(mysqli_stmt::class);
        $stmt->method('bind_param')->willReturn(true);
        $stmt->method('execute')->willReturn(true);
        $connect->method('prepare')->willReturn($stmt);
        $_POST['cats_name'] = $cats_name;

        // Act
        ob_start();
        include 'create-category.php';
        $result = json_decode(ob_get_clean(), true);

        // Assert
        $this->assertTrue($result['isSuccessful']);
        $this->assertEquals('Category created successfully.', $result['updateFeedback']);
    }
}

?>
