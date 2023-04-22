<?php
use PHPUnit\Framework\TestCase;

class ListCategoriesTest extends TestCase
{
    public function testListCategories()
    {
        // Arrange
        $connect = $this->createMock(mysqli::class);
        $stmt = $this->createMock(mysqli_stmt::class);
        $result = $this->createMock(mysqli_result::class);
        $row1 = ['cat_id' => 1, 'cat_name' => 'Category 1', 'cat_status' => 1];
        $row2 = ['cat_id' => 2, 'cat_name' => 'Category 2', 'cat_status' => 2];
        $result->method('num_rows')->willReturn(2);
        $result->method('fetch_assoc')->will($this->onConsecutiveCalls($row1, $row2));
        $stmt->method('bind_param')->willReturn(true);
        $stmt->method('execute')->willReturn(true);
        $stmt->method('get_result')->willReturn($result);
        $connect->method('prepare')->willReturn($stmt);

        // Act
        ob_start();
        include 'list-categories.php';
        $result = json_decode(ob_get_clean(), true);

        // Assert
        $this->assertArrayHasKey('data', $result);
        $this->assertCount(2, $result['data']);
        $this->assertEquals(['Category 1', '<div class="btn-group btn-group-justified" role="group" aria-label="Justified button group">
            <a type="button" class="btn btn-primary" data-toggle="modal" id="editCatsModalBtn" data-target="#editCatsModal" onclick="editCats(1)"> <i class="glyphicon glyphicon-edit"></i></a>
            <a  type="button" class="btn btn-danger" data-toggle="modal" data-target="#del_cats_modal" id="del_cats_modalBtn" onclick="removeCats(1)"> <i class="glyphicon glyphicon-trash"></i></a>       
        </div>'], $result['data'][0]);
        $this->assertEquals(['Category 2', '<div class="btn-group btn-group-justified" role="group" aria-label="Justified button group">
            <a type="button" class="btn btn-primary" data-toggle="modal" id="editCatsModalBtn" data-target="#editCatsModal" onclick="editCats(2)"> <i class="glyphicon glyphicon-edit"></i></a>
            <a  type="button" class="btn btn-danger" data-toggle="modal" data-target="#del_cats_modal" id="del_cats_modalBtn" onclick="removeCats(2)"> <i class="glyphicon glyphicon-trash"></i></a>       
        </div>'], $result['data'][1]);
    }
}
?>
