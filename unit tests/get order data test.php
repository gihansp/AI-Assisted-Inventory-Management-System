<?php

public function test_fetchOrderData()
{
    // Set up input data
    $orderId = 123;

    // Mock the database connection
    $stmtMock = $this->createMock(mysqli_stmt::class);
    $resultMock = $this->createMock(mysqli_result::class);
    $resultMock->expects($this->once())
               ->method('fetch_assoc')
               ->willReturn(['order_id' => $orderId]);
    $stmtMock->expects($this->once())
             ->method('get_result')
             ->willReturn($resultMock);
    $stmtMock->expects($this->once())
             ->method('bind_param')
             ->with('i', $orderId);
    $connectMock = $this->createMock(mysqli::class);
    $connectMock->expects($this->once())
                ->method('prepare')
                ->with('SELECT order_id, date_ordered, customer_name, customer_phone, total_before_tax, vat, total_invoice_amount, discount, total_amount_payable, paid, due, payment_method, payment_status FROM orders WHERE order_id = ?')
                ->willReturn($stmtMock);
    $GLOBALS['connect'] = $connectMock;

    // Call the function
    $expectedResult = ['order' => ['order_id' => $orderId], 'order_item' => []];
    $actualResult = fetchOrderData(['orderId' => $orderId]);

    // Check the result
    $this->assertEquals($expectedResult, $actualResult);
}

