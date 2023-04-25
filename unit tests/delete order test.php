<?php

public function testCancelOrder()
{
    $orderId = 1;

    $mockConnect = $this->getMockBuilder('mysqli')
        ->setMethods(['prepare', 'execute', 'close'])
        ->getMock();

    $mockStmt1 = $this->getMockBuilder('mysqli_stmt')
        ->setMethods(['bind_param', 'execute', 'close'])
        ->setConstructorArgs([$mockConnect])
        ->getMock();

    $mockStmt2 = $this->getMockBuilder('mysqli_stmt')
        ->setMethods(['bind_param', 'execute', 'close'])
        ->setConstructorArgs([$mockConnect])
        ->getMock();

    $mockConnect->expects($this->exactly(2))
        ->method('prepare')
        ->withConsecutive(['UPDATE orders SET order_status = 2 WHERE order_id = ?'], ['UPDATE order_item SET order_item_status = 2 WHERE order_id = ?'])
        ->willReturnOnConsecutiveCalls($mockStmt1, $mockStmt2);

    $mockStmt1->expects($this->once())
        ->method('bind_param')
        ->with('i', $orderId);

    $mockStmt2->expects($this->once())
        ->method('bind_param')
        ->with('i', $orderId);

    $mockStmt1->expects($this->once())
        ->method('execute')
        ->willReturn(true);

    $mockStmt2->expects($this->once())
        ->method('execute')
        ->willReturn(true);

    $mockStmt1->expects($this->once())
        ->method('close');

    $mockStmt2->expects($this->once())
        ->method('close');

    $mockConnect->expects($this->once())
        ->method('close');

    $expectedResponse = json_encode(['isSuccessful' => true, 'updateFeedback' => 'The order has been successfully removed from our system.']);

    $this->expectOutputString($expectedResponse);

    $_POST['orderId'] = $orderId;

    require_once 'cancel-order.php';
}

?>
