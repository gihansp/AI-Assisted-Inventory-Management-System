<?php

require_once '../session-check.php';

class ProductTest extends PHPUnit_Framework_TestCase
{
    private $connect;

    public function setUp()
    {
        $this->connect = new mysqli('localhost', 'username', 'password', 'database_name');

        if ($this->connect->connect_error) {
            die("Connection failed: " . $this->connect->connect_error);
        }
    }

    public function testProductListing()
    {
        $sql = "SELECT p.product_id, p.product_name, p.product_photo,
        p.cat_id, p.product_quantity, p.rate, p.active, p.status, 
        c.cat_name 
        FROM product AS p
        INNER JOIN categories AS c ON p.cat_id = c.cat_id  
        WHERE p.status = 1 AND p.product_quantity > 0";

        $result = $this->connect->query($sql);

        $output = array('data' => array());

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $prod_id = $row['product_id'];
                $active = ($row['active'] == 1) ? "<label class='label label-success'>Available</label>" : "<label class='label label-danger'>Not Available</label>";

                $button = '<div class="btn-group btn-group-justified" role="group" aria-label="Justified button group">
                  
                     
                       <a type="button"  class="btn btn-primary" data-toggle="modal" id="mdfyProdModalBtn" data-target="#mdfyProdModal" onclick="mdfyProd('.$prod_id.')"> <i class="glyphicon glyphicon-edit"></i></a>
                       <a type="button" class="btn btn-danger"  data-toggle="modal" data-target="#del_prod_modal" id="del_prod_modalBtn" onclick="deleteProd('.$prod_id.')"> <i class="glyphicon glyphicon-trash"></i></a>  
                  
                    </div>';

                $category = $row['cat_name'];

                $imageUrl = substr($row['product_photo'], 3);
                $prod_img = "<img class='img-round' src='".$imageUrl."' style='height:30px; width:50px;'  />";

                $output['data'][] = array(
                    $prod_img,
                    $row['product_name'],
                    $row['rate'],
                    $row['product_quantity'],
                    $category,
                    $button
                );
            }
        }

        $this->assertJson(json_encode($output));
    }

    public function tearDown()
    {
        $this->connect->close();
    }
}
