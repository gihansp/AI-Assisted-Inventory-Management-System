<?php

use PHPUnit\Framework\TestCase;

class RemoveCategoryTest extends TestCase
{
    public function testRemoveCategory()
    {
        // Arrange
        $categoriesId = 1;
        $connect = $this->createMock(mysqli::class);
        $stmt = $this->createMock(mysqli_stmt::class);
        $stmt->method('bind_param')->willReturn(true);
        $stmt->method('execute')->willReturn(true);
        $connect->method('prepare')->willReturn($stmt);
        $_POST['categoriesId'] = $categoriesId;

        // Act
        ob_start();
        include 'remove-category.php';
        $result = json_decode(ob_get_clean(), true);

        // Assert
        $this->assertTrue($result['isSuccessful']);
        $this->assertEquals('Category successfully removed.', $result['updateFeedback']);
    }
}

?>
