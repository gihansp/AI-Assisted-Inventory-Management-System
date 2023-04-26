<?php

public function test_fetchOrderData()
public function testFetchOrdersByDateRange()
{
    // Mock POST data
    $_POST['startDate'] = '05/01/2023';
    $_POST['endDate'] = '05/15/2023';

    // Mock database connection
    $mockConnection = $this->getMockBuilder(mysqli::class)
                           ->setMethods(['query'])
                           ->disableOriginalConstructor()
                           ->getMock();

    // Mock database query result
    $mockResult = $this->getMockBuilder(mysqli_result::class)
                       ->setMethods(['fetch_assoc'])
                       ->disableOriginalConstructor()
                       ->getMock();

    // Set expected query and results
    $expectedSql = "SELECT * FROM orders WHERE date_ordered >= '2023-05-01' AND date_ordered <= '2023-05-15' and order_status = 1";
    $expectedData = [        [            'date_ordered' => '2023-05-05',            'customer_name' => 'John Smith',            'customer_phone' => '555-555-5555',            'total_amount_payable' => '100.00'        ],
        [            'date_ordered' => '2023-05-10',            'customer_name' => 'Jane Doe',            'customer_phone' => '555-555-1234',            'total_amount_payable' => '50.00'        ]
    ];

    // Expect the query to be executed with the expected SQL statement
    $mockConnection->expects($this->once())
                   ->method('query')
                   ->with($this->equalTo($expectedSql))
                   ->willReturn($mockResult);

    // Expect the query result to be fetched twice (for each row of data)
    $mockResult->expects($this->exactly(2))
               ->method('fetch_assoc')
               ->willReturnOnConsecutiveCalls($expectedData[0], $expectedData[1]);

    // Create instance of orders controller
    $ordersController = new OrdersController($mockConnection);

    // Call method to fetch orders by date range
    $result = $ordersController->fetchOrdersByDateRange();

    // Assert that the expected HTML table was generated with the correct data
    $expectedTable = '<table border="1" cellspacing="0" cellpadding="0" style="width:100%;">';
    $expectedTable .= '<tr><th>Order Date</th><th>Client Name</th><th>Contact</th><th>Grand Total</th></tr>';
    $expectedTable .= '<tr><td><center>2023-05-05</center></td><td><center>John Smith</center></td><td><center>555-555-5555</center></td><td><center>100.00</center></td></tr>';
    $expectedTable .= '<tr><td><center>2023-05-10</center></td><td><center>Jane Doe</center></td><td><center>555-555-1234</center></td><td><center>50.00</center></td></tr>';
    $expectedTable .= '<tr><td colspan="3"><center>Total Amount</center></td><td><center>150.00</center></td></tr>';
    $expectedTable .= '</table>';
    $this->assertEquals($expectedTable, $result);
}

