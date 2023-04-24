<?php

public function testInsertOrder()
{
    $_POST = [
        'ord_date' => '2023-05-15',
        'cstmr_nm' => 'John Doe',
        'cstmr_contact' => '1234567890',
        'subtot_val' => 100,
        'vatValue' => 10,
        'totalAmountValue' => 110,
        'discount' => 5,
        'grandtot_val' => 105,
        'paid' => 105,
        'dueValue' => 0,
        'pay_type' => 1,
        'pay_status' => 1
    ];

    $mockConnection = $this->getMockBuilder(mysqli::class)
        ->disableOriginalConstructor()
        ->getMock();

    $mockConnection->expects($this->at(0))
        ->method('query')
        ->with("INSERT INTO orders (date_ordered, customer_name, customer_phone, total_before_tax, vat, total_invoice_amount, discount, total_amount_payable, paid, due, payment_method, payment_status, order_status, user_id) VALUES ('2023-05-15', 'John Doe', '1234567890', '100', '10', '110', '5', '105', '105', '0', 1, 1, 1, 1)")
        ->willReturn(true);

    $mockConnection->expects($this->at(1))
        ->method('insert_id')
        ->willReturn(1);

    $mockConnection->expects($this->at(2))
        ->method('query')
        ->with("UPDATE product SET product_quantity = product_quantity - 5 WHERE product_id = 1")
        ->willReturn(true);

    $mockConnection->expects($this->at(3))
        ->method('query')
        ->with("INSERT INTO order_item (order_id, product_id, product_quantity, rate, total, order_item_status) VALUES ('1', '1', '5', '20', '100', 1)")
        ->willReturn(true);

    $mockConnection->expects($this->at(4))
        ->method('query')
        ->with("INSERT INTO order_item (order_id, product_id, product_quantity, rate, total, order_item_status) VALUES ('1', '2', '2', '10', '20', 1)")
        ->willReturn(true);

    $mockConnection->expects($this->exactly(5))
        ->method('query')
        ->willReturn(true);

    $mockConnection->expects($this->once())
        ->method('close');

    $mockSession = $this->getMockBuilder(Session::class)
        ->getMock();

    $mockSession->expects($this->once())
        ->method('__get')
        ->with('userId')
        ->willReturn(1);

    $mockResponse = [
        'isSuccessful' => true,
        'updateFeedback' => 'Your order has been successfully placed.',
        'order_id' => 1
    ];

    $expectedJsonResponse = json_encode($mockResponse);

    $orderController = new OrderController($mockConnection, $mockSession);
    $result = $orderController->insertOrder();

    $this->assertEquals($expectedJsonResponse, $result);
}

