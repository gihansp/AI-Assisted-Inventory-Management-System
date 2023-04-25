<?php

require_once 'delete-category.php';

use PHPUnit\Framework\TestCase;

class deleteCategoryTest extends TestCase
{
    public function testValidCategoryID()
    {
        $_POST['categoryId'] = 1;

        // Expected response
        $expected = json_encode(array('success' => true, 'message' => 'Category successfully removed'));

        ob_start();
        deleteCategory();
        $result = ob_get_clean();

        $this->assertEquals($expected, $result);
    }

    public function testInvalidCategoryID()
    {
        $_POST = array();

        $expected = json_encode(array('success' => false, 'message' => 'Category ID is missing'));

        ob_start();
        deleteCategory();
        $result = ob_get_clean();

        $this->assertEquals($expected, $result);
    }
}
